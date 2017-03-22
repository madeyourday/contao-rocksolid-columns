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

$GLOBALS['TL_DCA']['tl_layout']['palettes']['default'] .= ';{rs_columns_legend},rs_columns_load_css';

$GLOBALS['TL_DCA']['tl_layout']['fields']['rs_columns_load_css'] = array(
	'inputType' => 'checkbox',
	'label' => &$GLOBALS['TL_LANG']['tl_layout']['rs_columns_load_css'],
	'sql' => "char(1) NOT NULL default '1'",
);
