<?php
/*
 * Copyright MADE/YOUR/DAY OG <mail@madeyourday.net>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace MadeYourDay\RockSolidColumns;

use Contao\Database;
use Contao\DataContainer;
use Contao\Encryption;
use Contao\LayoutModel;
use Contao\PageModel;
use Contao\PageRegular;

/**
 * RockSolid Columns DCA (tl_content and tl_module)
 *
 * Provide miscellaneous methods that are used by the data configuration arrays.
 *
 * @author Martin Auswöger <martin@madeyourday.net>
 */
class Columns
{
	/**
	 * generatePage hook
	 *
	 * @param  PageModel   $page
	 * @param  LayoutModel $layout
	 * @param  PageRegular $pageRegular
	 * @return void
	 */
	public function generatePageHook(PageModel $page, LayoutModel $layout, PageRegular $pageRegular)
	{
		if ($layout->rs_columns_load_css) {
			$GLOBALS['TL_CSS'][] = 'bundles/rocksolidcolumns/css/columns.css||static';
		}
	}

	/**
	 * getContentElement hook
	 *
	 * @param  Object $row     content element
	 * @param  string $content html content
	 * @return string          modified $content
	 */
	public function getContentElementHook($row, $content)
	{
		$parentKey = ($row->ptable ?: 'tl_article') . '__' . $row->pid;

		if (
			isset($GLOBALS['TL_RS_COLUMNS'][$parentKey])
			&& $GLOBALS['TL_RS_COLUMNS'][$parentKey]['active']
			&& $row->type !== 'rs_columns_start'
			&& $row->type !== 'rs_columns_stop'
			&& $row->type !== 'rs_column_start'
			&& $row->type !== 'rs_column_stop'
		) {

			$GLOBALS['TL_RS_COLUMNS'][$parentKey]['count']++;
			$count = $GLOBALS['TL_RS_COLUMNS'][$parentKey]['count'];

			if ($count) {

				$classes = array('rs-column');
				foreach ($GLOBALS['TL_RS_COLUMNS'][$parentKey]['config'] as $name => $media) {
					$classes = array_merge($classes, $media[($count - 1) % count($media)]);
					if ($count - 1 < count($media)) {
						$classes[] = '-' . $name . '-first-row';
					}
				}

				return '<div class="' . implode(' ', $classes) . '">' . $content . '</div>';

			}

		}

		return $content;
	}

	/**
	 * tl_content and tl_form_field DCA onsubmit callback
	 *
	 * Creates a stop element after a start element was created
	 *
	 * @param  DataContainer $dc Data container
	 * @return void
	 */
	public function onsubmitCallback($dc)
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
						if ($GLOBALS['TL_DCA'][$dc->table]['fields'][$field]['eval']['encrypt'] ?? false) {
							$set[$field] = Encryption::encrypt($set[$field]);
						}
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
