<?php
/*
 * Copyright MADE/YOUR/DAY OG <mail@madeyourday.net>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace MadeYourDay\RockSolidColumns\Element;

/**
 * Column start content element
 *
 * @author Martin Auswöger <martin@madeyourday.net>
 */
class ColumnStart extends \ContentElement
{
	/**
	 * @var string Template
	 */
	protected $strTemplate = 'ce_rs_column_start';

	/**
	 * Parse the template
	 *
	 * @return string Parsed element
	 */
	public function generate()
	{
		if (TL_MODE === 'BE') {
			return parent::generate();
		}

		$classes = array('rs-column');
		$parentKey = ($this->arrData['ptable'] ?: 'tl_article') . '__' . $this->arrData['pid'];

		if (isset($GLOBALS['TL_RS_COLUMNS'][$parentKey]) && $GLOBALS['TL_RS_COLUMNS'][$parentKey]['active']) {

			$GLOBALS['TL_RS_COLUMNS'][$parentKey]['active'] = false;
			$GLOBALS['TL_RS_COLUMNS'][$parentKey]['count']++;

			$count = $GLOBALS['TL_RS_COLUMNS'][$parentKey]['count'];
			foreach ($GLOBALS['TL_RS_COLUMNS'][$parentKey]['config'] as $name => $media) {
				$classes = array_merge($classes, $media[($count - 1) % count($media)]);
				if ($count - 1 < count($media)) {
					$classes[] = '-' . $name . '-first-row';
				}
			}

		}
		else {
			trigger_error('Missing column wrapper start element before column start element ID ' . $this->id . '.', E_USER_WARNING);
		}

		if (!is_array($this->cssID)) {
			$this->cssID = array('', '');
		}
		$this->arrData['cssID'][1] .= ' ' . implode(' ', $classes);

		return parent::generate();
	}

	/**
	 * Compile the content element
	 *
	 * @return void
	 */
	public function compile()
	{
		if (TL_MODE == 'BE') {
			$this->strTemplate = 'be_wildcard';
			$this->Template = new \BackendTemplate($this->strTemplate);
			$this->Template->title = $this->headline;
		}
		else {
			$this->Template = new \FrontendTemplate($this->strTemplate);
			$this->Template->setData($this->arrData);
		}
	}
}
