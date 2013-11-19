<?php
/*
 * Copyright MADE/YOUR/DAY OG <mail@madeyourday.net>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace MadeYourDay\Contao\Element;

/**
 * Column stop content element
 *
 * @author Martin Auswöger <martin@madeyourday.net>
 */
class ColumnStop extends \ContentElement
{
	/**
	 * @var string Template
	 */
	protected $strTemplate = 'ce_rs_column_stop';

	/**
	 * Parse the template
	 *
	 * @return string Parsed element
	 */
	public function generate()
	{
		$parentKey = ($this->arrData['ptable'] ?: 'tl_article') . '__' . $this->arrData['pid'];
		if (isset($GLOBALS['TL_RS_COLUMNS'][$parentKey])) {
			$GLOBALS['TL_RS_COLUMNS'][$parentKey]['active'] = true;
		}

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
