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
use MadeYourDay\RockSolidColumns\Columns;
use MadeYourDay\RockSolidColumns\Element\ColumnsStart;
use MadeYourDay\RockSolidColumns\Element\ColumnsStop;
use MadeYourDay\RockSolidColumns\Element\ColumnStart;
use MadeYourDay\RockSolidColumns\Element\ColumnStop;

$GLOBALS['TL_HOOKS']['generatePage'][] = array(Columns::class, 'generatePageHook');
$GLOBALS['TL_HOOKS']['getContentElement'][] = array(Columns::class, 'getContentElementHook');

$GLOBALS['TL_CTE']['rs_columns']['rs_columns_start'] = ColumnsStart::class;
$GLOBALS['TL_CTE']['rs_columns']['rs_columns_stop'] = ColumnsStop::class;
$GLOBALS['TL_CTE']['rs_columns']['rs_column_start'] = ColumnStart::class;
$GLOBALS['TL_CTE']['rs_columns']['rs_column_stop'] = ColumnStop::class;

$GLOBALS['TL_FFL']['rs_columns_start'] = ColumnsWidget::class;
$GLOBALS['TL_FFL']['rs_columns_stop'] = ColumnsWidget::class;
$GLOBALS['TL_FFL']['rs_column_start'] = ColumnsWidget::class;
$GLOBALS['TL_FFL']['rs_column_stop'] = ColumnsWidget::class;

$GLOBALS['TL_WRAPPERS']['start'][] = 'rs_columns_start';
$GLOBALS['TL_WRAPPERS']['stop'][] = 'rs_columns_stop';
$GLOBALS['TL_WRAPPERS']['start'][] = 'rs_column_start';
$GLOBALS['TL_WRAPPERS']['stop'][] = 'rs_column_stop';
