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

use Contao\System;
use Symfony\Component\HttpFoundation\Request;

if (System::getContainer()->get('contao.routing.scope_matcher')->isBackendRequest(System::getContainer()->get('request_stack')->getCurrentRequest() ?? Request::create(''))) {
	$GLOBALS['TL_CSS'][] = 'bundles/rocksolidcolumns/css/be_main.css';
}

$GLOBALS['TL_DCA']['tl_content']['config']['onsubmit_callback'][] = array('MadeYourDay\\RockSolidColumns\\Columns', 'onsubmitCallback');

$GLOBALS['TL_DCA']['tl_content']['palettes']['rs_columns_start'] = '{type_legend},type,headline;{rs_columns_legend},rs_columns_large,rs_columns_medium,rs_columns_small;{protected_legend:hide},protected;{expert_legend:hide},guests,cssID;{invisible_legend:hide},invisible,start,stop';
$GLOBALS['TL_DCA']['tl_content']['palettes']['rs_columns_stop'] = '{type_legend},type;{protected_legend:hide},protected;{expert_legend:hide},guests;{invisible_legend:hide},invisible,start,stop';
$GLOBALS['TL_DCA']['tl_content']['palettes']['rs_column_start'] = '{type_legend},type,headline;{protected_legend:hide},protected;{expert_legend:hide},guests,cssID;{invisible_legend:hide},invisible,start,stop';
$GLOBALS['TL_DCA']['tl_content']['palettes']['rs_column_stop'] = '{type_legend},type;{protected_legend:hide},protected;{expert_legend:hide},guests;{invisible_legend:hide},invisible,start,stop';

$GLOBALS['TL_DCA']['tl_content']['fields']['rs_columns_large'] = array(
    'exclude' => true,
	'inputType' => 'text',
	'label' => &$GLOBALS['TL_LANG']['tl_content']['rs_columns_large'],
	'eval' => array(
		'tl_class' => 'rs_columns_w33',
	),
	'sql' => "varchar(255) NOT NULL default ''",
);
$GLOBALS['TL_DCA']['tl_content']['fields']['rs_columns_medium'] = array(
	'exclude' => true,
	'inputType' => 'text',
	'label' => &$GLOBALS['TL_LANG']['tl_content']['rs_columns_medium'],
	'eval' => array(
		'tl_class' => 'rs_columns_w33',
	),
	'sql' => "varchar(255) NOT NULL default ''",
);
$GLOBALS['TL_DCA']['tl_content']['fields']['rs_columns_small'] = array(
	'exclude' => true,
	'inputType' => 'text',
	'label' => &$GLOBALS['TL_LANG']['tl_content']['rs_columns_small'],
	'eval' => array(
		'tl_class' => 'rs_columns_w33',
	),
	'sql' => "varchar(255) NOT NULL default ''",
);
