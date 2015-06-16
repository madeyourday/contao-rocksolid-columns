<?php
/*
 * Copyright MADE/YOUR/DAY OG <mail@madeyourday.net>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * RockSolid Columns autload configuration
 *
 * @author Martin Auswöger <martin@madeyourday.net>
 */

ClassLoader::addClasses(array(
	'MadeYourDay\\Contao\\Element\\ColumnsStart' => 'system/modules/rocksolid-columns/src/MadeYourDay/Contao/Element/ColumnsStart.php',
	'MadeYourDay\\Contao\\Element\\ColumnsStop' => 'system/modules/rocksolid-columns/src/MadeYourDay/Contao/Element/ColumnsStop.php',
	'MadeYourDay\\Contao\\Element\\ColumnStart' => 'system/modules/rocksolid-columns/src/MadeYourDay/Contao/Element/ColumnStart.php',
	'MadeYourDay\\Contao\\Element\\ColumnStop' => 'system/modules/rocksolid-columns/src/MadeYourDay/Contao/Element/ColumnStop.php',
	'MadeYourDay\\Contao\\Columns' => 'system/modules/rocksolid-columns/src/MadeYourDay/Contao/Columns.php',
));

$templatesFolder = version_compare(VERSION, '4.0', '>=')
	? 'vendor/madeyourday/contao-rocksolid-columns/templates'
	: 'system/modules/rocksolid-columns/templates';

TemplateLoader::addFiles(array(
	'ce_rs_columns_start' => $templatesFolder,
	'ce_rs_columns_stop' => $templatesFolder,
	'ce_rs_column_start' => $templatesFolder,
	'ce_rs_column_stop' => $templatesFolder,
));
