<?php
/*
 * Copyright MADE/YOUR/DAY OG <mail@madeyourday.net>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * RockSolid Columns DCA
 *
 * @author Martin Auswöger <martin@madeyourday.net>
 */

if (TL_MODE === 'BE') {
	$GLOBALS['TL_CSS'][] = 'system/modules/rocksolid-columns/assets/css/be_main.css';
}

$GLOBALS['TL_DCA']['tl_content']['palettes']['rs_columns_start'] = '{type_legend},type,headline;{rs_columns_legend},rs_columns_large,rs_columns_medium,rs_columns_small;{protected_legend:hide},protected;{expert_legend:hide},guests,cssID,space;{invisible_legend:hide},invisible,start,stop';

$GLOBALS['TL_DCA']['tl_content']['fields']['rs_columns_large'] = array(
	'inputType' => 'text',
	'label' => &$GLOBALS['TL_LANG']['tl_content']['rs_columns_large'],
	'eval' => array(
		'tl_class' => 'rs_columns_w33',
		'mandatory' => true,
	),
	'sql' => "varchar(255) NOT NULL default ''",
);
$GLOBALS['TL_DCA']['tl_content']['fields']['rs_columns_medium'] = array(
	'inputType' => 'text',
	'label' => &$GLOBALS['TL_LANG']['tl_content']['rs_columns_medium'],
	'eval' => array(
		'tl_class' => 'rs_columns_w33',
		'mandatory' => false,
	),
	'sql' => "varchar(255) NOT NULL default ''",
);
$GLOBALS['TL_DCA']['tl_content']['fields']['rs_columns_small'] = array(
	'inputType' => 'text',
	'label' => &$GLOBALS['TL_LANG']['tl_content']['rs_columns_small'],
	'eval' => array(
		'tl_class' => 'rs_columns_w33',
		'mandatory' => false,
	),
	'sql' => "varchar(255) NOT NULL default ''",
);
