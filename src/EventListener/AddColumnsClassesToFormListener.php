<?php
/*
 * Copyright MADE/YOUR/DAY OG <mail@madeyourday.net>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace MadeYourDay\RockSolidColumns\EventListener;

use Contao\CoreBundle\ServiceAnnotation\Hook;
use Contao\Form;
use Contao\Widget;

/**
 * @Hook("loadFormField")
 */
class AddColumnsClassesToFormListener
{
    public function __invoke(Widget $widget, string $formId, array $data, Form $form): Widget
    {
        $parentKey = 'tl_form__'.$widget->pid;
        $excludeWidgets = ['rs_columns_start', 'rs_columns_stop', 'rs_column_start', 'rs_column_stop'];

        if (isset($GLOBALS['TL_RS_COLUMNS'][$parentKey])
            && $GLOBALS['TL_RS_COLUMNS'][$parentKey]['active']
            && !\in_array($widget->type, $excludeWidgets, true)
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

                if ('fieldsetStart' === $widget->type || 'submit' === $widget->type) {
                    $widget->class .= ' '.implode(' ', $classes);
                } else {
                    $widget->prefix .= ' '.implode(' ', $classes);
                }
            }
        }

        return $widget;
    }
}
