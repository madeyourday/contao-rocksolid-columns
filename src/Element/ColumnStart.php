<?php
/*
 * Copyright MADE/YOUR/DAY OG <mail@madeyourday.net>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace MadeYourDay\RockSolidColumns\Element;

use Contao\BackendTemplate;
use Contao\ContentElement;
use Contao\File;
use Contao\FilesModel;
use Contao\FrontendTemplate;
use Contao\StringUtil;
use Contao\System;
use Symfony\Component\HttpFoundation\Request;

/**
 * Column start content element
 *
 * @author Martin Auswöger <martin@madeyourday.net>
 */
class ColumnStart extends ContentElement
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
		if (System::getContainer()->get('contao.routing.scope_matcher')->isBackendRequest(System::getContainer()->get('request_stack')->getCurrentRequest() ?? Request::create(''))) {
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

		if ($this->rs_column_color_inverted) {
			$classes[] = '-color-inverted';
		}

		if ($this->rs_column_background) {

			$backgroundColor = StringUtil::deserialize($this->rs_column_background_color);
			if (is_array($backgroundColor) && $backgroundColor[0]) {
				$this->arrStyle[] = 'background-color: #' . $backgroundColor[0] . ';';
			}

			if (trim($this->rs_column_background_image)) {
				$image = FilesModel::findByPk($this->rs_column_background_image);
				$file = new File($image->path, true);
				$imageObject = new \stdClass();
				$this->addImageToTemplate($imageObject, array(
					'id' => $image->id,
					'uuid' => isset($image->uuid) ? $image->uuid : null,
					'name' => $file->basename,
					'singleSRC' => $image->path,
					'size' => $this->rs_column_background_image_size,
				));
				$this->arrStyle[] = 'background-image: url(&quot;' . $imageObject->src . '&quot;);';
			}

			if ($this->rs_column_background_size) {
				$this->arrStyle[] = 'background-size: ' . $this->rs_column_background_size . ';';
			}

			if ($this->rs_column_background_position) {
				$this->arrStyle[] = 'background-position: ' . $this->rs_column_background_position . ';';
			}

			if ($this->rs_column_background_repeat) {
				$this->arrStyle[] = 'background-repeat: ' . $this->rs_column_background_repeat . ';';
			}

		}

		if (!is_array($this->cssID)) {
			$this->cssID = array('', '');
		}
		else {
			$this->cssID = $this->cssID + array('', '');
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
		if (System::getContainer()->get('contao.routing.scope_matcher')->isBackendRequest(System::getContainer()->get('request_stack')->getCurrentRequest() ?? Request::create(''))) {
			$this->strTemplate = 'be_wildcard';
			$this->Template = new BackendTemplate($this->strTemplate);
			$this->Template->title = $this->headline;
		}
		else {
			$this->Template = new FrontendTemplate($this->strTemplate);
			$this->Template->setData($this->arrData);
		}
	}
}
