<?php
/*
 * Copyright MADE/YOUR/DAY OG <mail@madeyourday.net>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace MadeYourDay\RockSolidColumns\Element;

/**
 * Columns start content element
 *
 * @author Martin Auswöger <martin@madeyourday.net>
 */
class ColumnsStart extends \ContentElement
{
	/**
	 * @var string Template
	 */
	protected $strTemplate = 'ce_rs_columns_start';

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

		$parentKey = ($this->arrData['ptable'] ?: 'tl_article') . '__' . $this->arrData['pid'];

		$htmlPrefix = '';

		if (!empty($GLOBALS['TL_RS_COLUMNS'][$parentKey])) {

			if ($GLOBALS['TL_RS_COLUMNS'][$parentKey]['active']) {

				$GLOBALS['TL_RS_COLUMNS'][$parentKey]['count']++;
				$count = $GLOBALS['TL_RS_COLUMNS'][$parentKey]['count'];

				if ($count) {

					$classes = array('rs-column');
					foreach ($GLOBALS['TL_RS_COLUMNS'][$parentKey]['config'] as $name => $media) {
						$classes = array_merge($classes, $media[($count - 1) % count($media)]);
						if ($count - 1 < count($media)) {
							$classes[] = '-' . $name . '-first-row';
						}
					}

					$htmlPrefix .= '<div class="' . implode(' ', $classes) . '">';

				}

			}

			$GLOBALS['TL_RS_COLUMNS_STACK'][$parentKey][] = $GLOBALS['TL_RS_COLUMNS'][$parentKey];
		}

		$GLOBALS['TL_RS_COLUMNS'][$parentKey] = array(
			'active' => true,
			'count' => 0,
			'config' => static::getColumnsConfiguration($this->arrData),
		);

		return $htmlPrefix . parent::generate();
	}

	/**
	 * Generate the columns configuration
	 *
	 * @param  array $data Data array
	 * @return array       Columns configuration
	 */
	public static function getColumnsConfiguration(array $data)
	{
		$config = array();
		$lastColumns = null;

		foreach (array('large', 'medium', 'small') as $media) {

			$columns = isset($data['rs_columns_' . $media])
				? $data['rs_columns_' . $media]
				: null;
			if (!$columns) {
				$columns = $lastColumns ?: '2';
			}
			$lastColumns = $columns;

			$columns = array_map(function($value) {
				return (int)$value ?: 1;
			}, explode('-', $columns));

			if (count($columns) === 1 && $columns[0] > 1) {
				$columns = array_fill(0, (int)$columns[0], '1');
			}

			$columnsTotal = array_reduce($columns, function($a, $b) {
				return $a + $b;
			});
			$classes = array();
			foreach ($columns as $key => $column) {
				$classes[] = array('-' . $media . '-col-' . $columnsTotal . '-' . $column);
			}
			$classes[0][] = '-' . $media . '-first';
			$classes[count($classes) - 1][] = '-' . $media . '-last';
			$config[$media] = $classes;

		}

		return $config;
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
