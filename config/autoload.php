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
	'MadeYourDay\\Contao\\Columns' => 'system/modules/rocksolid-columns/src/MadeYourDay/Contao/Columns.php',
));

TemplateLoader::addFiles(array(
	'ce_rs_columns_start' => 'system/modules/rocksolid-columns/templates',
	'ce_rs_columns_stop' => 'system/modules/rocksolid-columns/templates',
));
