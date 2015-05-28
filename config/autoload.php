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
	'MadeYourDay\\Contao\\Form\\ColumnsWidget' => 'system/modules/rocksolid-columns/src/MadeYourDay/Contao/Form/ColumnsWidget.php',
	'MadeYourDay\\Contao\\Columns' => 'system/modules/rocksolid-columns/src/MadeYourDay/Contao/Columns.php',
	'MadeYourDay\\Contao\\Model\\DummyColumnsModel' => 'system/modules/rocksolid-columns/src/MadeYourDay/Contao/Model/DummyColumnsModel.php',
));

TemplateLoader::addFiles(array(
	'form_rs_columns_plain' => 'system/modules/rocksolid-columns/templates',
	'ce_rs_columns_start' => 'system/modules/rocksolid-columns/templates',
	'ce_rs_columns_stop' => 'system/modules/rocksolid-columns/templates',
	'ce_rs_column_start' => 'system/modules/rocksolid-columns/templates',
	'ce_rs_column_stop' => 'system/modules/rocksolid-columns/templates',
));
