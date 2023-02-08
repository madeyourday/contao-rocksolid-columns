<?php
/*
 * Copyright MADE/YOUR/DAY OG <mail@madeyourday.net>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * RockSolid Columns configuration
 *
 * @author Martin Auswöger <martin@madeyourday.net>
 */

use MadeYourDay\Contao\Form\ColumnsWidget;

$GLOBALS['TL_FFL']['rs_columns_start'] = ColumnsWidget::class;
$GLOBALS['TL_FFL']['rs_columns_stop'] = ColumnsWidget::class;
$GLOBALS['TL_FFL']['rs_column_start'] = ColumnsWidget::class;
$GLOBALS['TL_FFL']['rs_column_stop'] = ColumnsWidget::class;

$GLOBALS['TL_WRAPPERS']['start'][] = 'rs_columns_start';
$GLOBALS['TL_WRAPPERS']['stop'][] = 'rs_columns_stop';
$GLOBALS['TL_WRAPPERS']['start'][] = 'rs_column_start';
$GLOBALS['TL_WRAPPERS']['stop'][] = 'rs_column_stop';
