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

$GLOBALS['TL_HOOKS']['generatePage'][] = array('MadeYourDay\\Contao\\Columns', 'generatePageHook');
$GLOBALS['TL_HOOKS']['getContentElement'][] = array('MadeYourDay\\Contao\\Columns', 'getContentElementHook');

$GLOBALS['TL_CTE']['rs_columns']['rs_columns_start'] = 'MadeYourDay\\Contao\\Element\\ColumnsStart';
$GLOBALS['TL_CTE']['rs_columns']['rs_columns_stop'] = 'MadeYourDay\\Contao\\Element\\ColumnsStop';
$GLOBALS['TL_CTE']['rs_columns']['rs_column_start'] = 'MadeYourDay\\Contao\\Element\\ColumnStart';
$GLOBALS['TL_CTE']['rs_columns']['rs_column_stop'] = 'MadeYourDay\\Contao\\Element\\ColumnStop';

$GLOBALS['TL_WRAPPERS']['start'][] = 'rs_columns_start';
$GLOBALS['TL_WRAPPERS']['stop'][] = 'rs_columns_stop';
$GLOBALS['TL_WRAPPERS']['start'][] = 'rs_column_start';
$GLOBALS['TL_WRAPPERS']['stop'][] = 'rs_column_stop';
