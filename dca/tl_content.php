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

$GLOBALS['TL_DCA']['tl_content']['config']['onsubmit_callback'][] = array('MadeYourDay\\Contao\\Columns', 'onsubmitCallback');

$GLOBALS['TL_DCA']['tl_content']['palettes']['rs_columns_start'] = '{type_legend},type,headline;{rs_columns_legend},rs_columns_xlarge,rs_columns_large,rs_columns_medium,rs_columns_small,rs_columns_xsmall,rs_columns_gutter,rs_columns_outside_gutters,rs_columns_equal_height;{protected_legend:hide},protected;{expert_legend:hide},guests,cssID,space;{invisible_legend:hide},invisible,start,stop';
$GLOBALS['TL_DCA']['tl_content']['palettes']['rs_columns_stop'] = '{type_legend},type;{protected_legend:hide},protected;{invisible_legend:hide},invisible,start,stop';
$GLOBALS['TL_DCA']['tl_content']['palettes']['rs_column_start'] = '{type_legend},type,headline;{rs_column_background_legend},rs_column_color_inverted,rs_column_background;{protected_legend:hide},protected;{expert_legend:hide},guests,cssID,space;{invisible_legend:hide},invisible,start,stop';
$GLOBALS['TL_DCA']['tl_content']['palettes']['rs_column_stop'] = '{type_legend},type;{protected_legend:hide},protected;{invisible_legend:hide},invisible,start,stop';

$GLOBALS['TL_DCA']['tl_content']['palettes']['__selector__'][] = 'rs_column_background';
$GLOBALS['TL_DCA']['tl_content']['subpalettes']['rs_column_background'] = 'rs_column_background_color,rs_column_background_image,rs_column_background_image_size,rs_column_background_size,rs_column_background_position,rs_column_background_repeat';

$GLOBALS['TL_DCA']['tl_content']['fields']['rs_columns_xlarge'] = array(
	'inputType' => 'text',
	'label' => &$GLOBALS['TL_LANG']['tl_content']['rs_columns_xlarge'],
	'exclude' => true,
	'eval' => array(
		'tl_class' => 'rs_columns_w20 clr',
	),
	'sql' => "varchar(255) NOT NULL default ''",
);
$GLOBALS['TL_DCA']['tl_content']['fields']['rs_columns_large'] = array(
	'inputType' => 'text',
	'label' => &$GLOBALS['TL_LANG']['tl_content']['rs_columns_large'],
	'exclude' => true,
	'eval' => array(
		'tl_class' => 'rs_columns_w20',
	),
	'sql' => "varchar(255) NOT NULL default ''",
);
$GLOBALS['TL_DCA']['tl_content']['fields']['rs_columns_medium'] = array(
	'inputType' => 'text',
	'label' => &$GLOBALS['TL_LANG']['tl_content']['rs_columns_medium'],
	'exclude' => true,
	'eval' => array(
		'tl_class' => 'rs_columns_w20',
	),
	'sql' => "varchar(255) NOT NULL default ''",
);
$GLOBALS['TL_DCA']['tl_content']['fields']['rs_columns_small'] = array(
	'inputType' => 'text',
	'label' => &$GLOBALS['TL_LANG']['tl_content']['rs_columns_small'],
	'exclude' => true,
	'eval' => array(
		'tl_class' => 'rs_columns_w20',
	),
	'sql' => "varchar(255) NOT NULL default ''",
);
$GLOBALS['TL_DCA']['tl_content']['fields']['rs_columns_xsmall'] = array(
	'inputType' => 'text',
	'label' => &$GLOBALS['TL_LANG']['tl_content']['rs_columns_xsmall'],
	'exclude' => true,
	'eval' => array(
		'tl_class' => 'rs_columns_w20',
	),
	'sql' => "varchar(255) NOT NULL default ''",
);
$GLOBALS['TL_DCA']['tl_content']['fields']['rs_columns_gutter'] = array(
	'inputType' => 'select',
	'label' => &$GLOBALS['TL_LANG']['tl_content']['rs_columns_gutter'],
	'exclude' => true,
	'options' => array('none', 's', 'm', 'l'),
	'reference' => &$GLOBALS['TL_LANG']['tl_content']['rs_columns_gutters'],
	'eval' => array(
		'includeBlankOption' => true,
		'tl_class' => 'clr',
	),
	'sql' => "varchar(255) NOT NULL default ''",
);
$GLOBALS['TL_DCA']['tl_content']['fields']['rs_columns_outside_gutters'] = array(
	'inputType' => 'checkbox',
	'label' => &$GLOBALS['TL_LANG']['tl_content']['rs_columns_outside_gutters'],
	'exclude' => true,
	'eval' => array(
		'tl_class' => 'w50 m12 clr',
	),
	'sql' => "char(1) NOT NULL default ''",
);
$GLOBALS['TL_DCA']['tl_content']['fields']['rs_columns_equal_height'] = array(
	'inputType' => 'checkbox',
	'label' => &$GLOBALS['TL_LANG']['tl_content']['rs_columns_equal_height'],
	'exclude' => true,
	'eval' => array(
		'tl_class' => 'w50 m12',
	),
	'sql' => "char(1) NOT NULL default ''",
);

$GLOBALS['TL_DCA']['tl_content']['fields']['rs_column_color_inverted'] = array(
	'inputType' => 'checkbox',
	'label' => &$GLOBALS['TL_LANG']['tl_content']['rs_column_color_inverted'],
	'exclude' => true,
	'eval' => array(
		'tl_class' => 'w50 clr',
	),
	'sql' => "char(1) NOT NULL default ''",
);
$GLOBALS['TL_DCA']['tl_content']['fields']['rs_column_background'] = array(
	'inputType' => 'checkbox',
	'label' => &$GLOBALS['TL_LANG']['tl_content']['rs_column_background'],
	'exclude' => true,
	'eval' => array(
		'tl_class' => 'w50',
		'submitOnChange' => true,
	),
	'sql' => "char(1) NOT NULL default ''",
);
$GLOBALS['TL_DCA']['tl_content']['fields']['rs_column_background_color'] = array(
	'label' => &$GLOBALS['TL_LANG']['tl_content']['rs_column_background_color'],
	'exclude' => true,
	'inputType' => 'text',
	'eval' => array(
		'maxlength' => 6,
		'multiple' => true,
		'size' => 2,
		'colorpicker' => true,
		'isHexColor' => true,
		'decodeEntities' => true,
		'tl_class' => 'w50 wizard',
	),
	'sql' => "varchar(64) NOT NULL default ''",
);
$GLOBALS['TL_DCA']['tl_content']['fields']['rs_column_background_image'] = array(
	'label' => &$GLOBALS['TL_LANG']['tl_content']['rs_column_background_image'],
	'exclude' => true,
	'inputType' => 'fileTree',
	'eval' => array(
		'tl_class' => 'clr',
		'multiple' => false,
		'fieldType' => 'radio',
		'filesOnly' => true,
		'extensions' => \Config::get('validImageTypes'),
	),
	'sql' => "binary(16) NULL",
);
$GLOBALS['TL_DCA']['tl_content']['fields']['rs_column_background_image_size'] = array(
	'label' => &$GLOBALS['TL_LANG']['tl_content']['rs_column_background_image_size'],
	'exclude' => true,
	'inputType' => 'imageSize',
	'options' => version_compare(VERSION, '3.4', '<') ? $GLOBALS['TL_CROP'] : System::getImageSizes(),
	'reference' => &$GLOBALS['TL_LANG']['MSC'],
	'eval' => array(
		'rgxp' => 'digit',
		'nospace' => true,
		'helpwizard' => true,
		'tl_class' => 'w50',
		'includeBlankOption' => true,
	),
	'sql' => "varchar(64) NOT NULL default ''",
);
$GLOBALS['TL_DCA']['tl_content']['fields']['rs_column_background_size'] = array(
	'label' => &$GLOBALS['TL_LANG']['tl_content']['rs_column_background_size'],
	'exclude' => true,
	'inputType' => 'select',
	'options' => array(
		'cover',
		'contain',
		'100% 100%',
		'auto auto',
	),
	'reference' => &$GLOBALS['TL_LANG']['tl_content']['rs_column_background_sizes'],
	'eval' => array(
		'includeBlankOption' => true,
		'tl_class' => 'w50'
	),
	'sql' => "varchar(64) NOT NULL default ''",
);
$GLOBALS['TL_DCA']['tl_content']['fields']['rs_column_background_position'] = array(
	'label' => &$GLOBALS['TL_LANG']['tl_content']['rs_column_background_position'],
	'exclude' => true,
	'inputType' => 'select',
	'options' => array(
		'left top',
		'left center',
		'left bottom',
		'center top',
		'center center',
		'center bottom',
		'right top',
		'right center',
		'right bottom',
	),
	'eval' => array(
		'includeBlankOption' => true,
		'tl_class'=>'w50',
	),
	'sql' => "varchar(32) NOT NULL default ''",
);
$GLOBALS['TL_DCA']['tl_content']['fields']['rs_column_background_repeat'] = array(
	'label' => &$GLOBALS['TL_LANG']['tl_content']['rs_column_background_repeat'],
	'exclude' => true,
	'inputType' => 'select',
	'options' => array(
		'repeat',
		'repeat-x',
		'repeat-y',
		'no-repeat',
	),
	'eval' => array(
		'includeBlankOption' => true,
		'tl_class'=>'w50',
	),
	'sql' => "varchar(32) NOT NULL default ''",
);
