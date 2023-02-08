<?php
/*
 * Copyright MADE/YOUR/DAY OG <mail@madeyourday.net>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace MadeYourDay\RockSolidColumns\EventListener;

use Contao\ContentModel;
use Contao\CoreBundle\ServiceAnnotation\Hook;

/**
 * @Hook("getContentElement")
 */
class AddColumnsClassesToContentListener
{
    public function __invoke(ContentModel $contentModel, string $buffer, $element): string
    {
        $parentKey = ($contentModel->ptable ?: 'tl_article').'__'.$contentModel->pid;

        if (
            isset($GLOBALS['TL_RS_COLUMNS'][$parentKey])
            && $GLOBALS['TL_RS_COLUMNS'][$parentKey]['active']
            && $contentModel->type !== 'rs_columns_start'
            && $contentModel->type !== 'rs_columns_stop'
            && $contentModel->type !== 'rs_column_start'
            && $contentModel->type !== 'rs_column_stop'
        ) {

            $GLOBALS['TL_RS_COLUMNS'][$parentKey]['count']++;
            $count = $GLOBALS['TL_RS_COLUMNS'][$parentKey]['count'];

            if ($count) {

                $classes = array('rs-column');
                foreach ($GLOBALS['TL_RS_COLUMNS'][$parentKey]['config'] as $name => $media) {
                    $classes = array_merge($classes, $media[($count - 1) % count($media)]);
                    if ($count - 1 < count($media)) {
                        $classes[] = '-'.$name.'-first-row';
                    }
                }

                return '<div class="'.implode(' ', $classes).'">'.$buffer.'</div>';

            }

        }

        return $buffer;
    }
}
