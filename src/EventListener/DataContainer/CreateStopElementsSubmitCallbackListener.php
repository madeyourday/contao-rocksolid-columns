<?php
/*
 * Copyright MADE/YOUR/DAY OG <mail@madeyourday.net>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace MadeYourDay\RockSolidColumns\EventListener\DataContainer;

use Contao\CoreBundle\ServiceAnnotation\Callback;
use Contao\Database;
use Contao\DataContainer;

/**
 * @Callback(table="tl_content", target="config.onsubmit")
 * @Callback(table="tl_form_field", target="config.onsubmit")
 */
class CreateStopElementsSubmitCallbackListener
{
    public function __invoke(DataContainer $dc): void
    {
        $activeRecord = $dc->activeRecord;
        if (!$activeRecord) {
            return;
        }

        if ($activeRecord->type === 'rs_columns_start' || $activeRecord->type === 'rs_column_start') {

            if ($dc->table === 'tl_content') {

                // Find the next columns or column element
                $nextElement = Database::getInstance()
                    ->prepare('
						SELECT type
						FROM tl_content
						WHERE pid = ?
							AND (ptable = ? OR ptable = ?)
							AND type IN (\'rs_column_start\', \'rs_column_stop\', \'rs_columns_start\', \'rs_columns_stop\')
							AND sorting > ?
						ORDER BY sorting ASC
						LIMIT 1
					')
                    ->execute(
                        $activeRecord->pid,
                        $activeRecord->ptable ?: 'tl_article',
                        $activeRecord->ptable === 'tl_article' ? '' : $activeRecord->ptable,
                        $activeRecord->sorting
                    );

            }
            else {

                // Find the next columns or column element
                $nextElement = Database::getInstance()
                    ->prepare('
						SELECT type
						FROM ' . $dc->table . '
						WHERE pid = ?
							AND type IN (\'rs_column_start\', \'rs_column_stop\', \'rs_columns_start\', \'rs_columns_stop\')
							AND sorting > ?
						ORDER BY sorting ASC
						LIMIT 1
					')
                    ->execute(
                        $activeRecord->pid,
                        $activeRecord->sorting
                    );

            }

            // Check if a stop element should be created
            if (
                !$nextElement->type
                || ($activeRecord->type === 'rs_columns_start' && $nextElement->type === 'rs_column_stop')
                || ($activeRecord->type === 'rs_column_start' && (
                        $nextElement->type === 'rs_column_start' || $nextElement->type === 'rs_columns_stop'
                    ))
            ) {
                $set = array();

                // Get all default values for the new entry
                foreach ($GLOBALS['TL_DCA'][$dc->table]['fields'] as $field => $config) {
                    if (array_key_exists('default', $config)) {
                        $set[$field] = \is_array($config['default']) ? serialize($config['default']) : $config['default'];
                    }
                }

                $set['pid'] = $activeRecord->pid;
                $set['type'] = substr($activeRecord->type, 0, -5) . 'stop';
                $set['sorting'] = $activeRecord->sorting + 1;
                $set['invisible'] = $activeRecord->invisible;
                $set['tstamp'] = time();

                if ($dc->table === 'tl_content') {
                    $set['ptable'] = $activeRecord->ptable ?: 'tl_article';
                    $set['start'] = $activeRecord->start;
                    $set['stop'] = $activeRecord->stop;
                }

                Database::getInstance()
                    ->prepare('INSERT INTO ' . $dc->table . ' %s')
                    ->set($set)
                    ->execute();
            }
        }
    }
}
