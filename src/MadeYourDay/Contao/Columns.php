<?php
/*
 * Copyright MADE/YOUR/DAY OG <mail@madeyourday.net>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace MadeYourDay\Contao;

/**
 * RockSolid Columns DCA (tl_content and tl_module)
 *
 * Provide miscellaneous methods that are used by the data configuration arrays.
 *
 * @author Martin Auswöger <martin@madeyourday.net>
 */
class Columns
{
	/**
	 * generatePage hook
	 *
	 * @param  \PageModel   $page
	 * @param  \LayoutModel $layout
	 * @param  \PageRegular $pageRegular
	 * @return void
	 */
	public function generatePageHook(\PageModel $page, \LayoutModel $layout, \PageRegular $pageRegular)
	{
		if ($layout->rs_columns_load_css) {
			$GLOBALS['TL_CSS'][] = 'system/modules/rocksolid-columns/assets/css/columns.css||static';
		}
	}

	/**
	 * getContentElement hook
	 *
	 * @param  Object $row     content element
	 * @param  string $content html content
	 * @return string          modified $content
	 */
	public function getContentElementHook($row, $content, $element)
	{
		$parentKey = ($row->ptable ?: 'tl_article') . '__' . $row->pid;

		if (isset($GLOBALS['TL_RS_COLUMNS'][$parentKey])) {

			$count = $GLOBALS['TL_RS_COLUMNS'][$parentKey]['count']++;
			if ($count) {

				$classes = array('rs-column');
				foreach ($GLOBALS['TL_RS_COLUMNS'][$parentKey]['config'] as $media) {
					$classes = array_merge($classes, $media[($count - 1) % count($media)]);
				}

				return '<div class="' . implode(' ', $classes) . '">' . $content . '</div>';

			}

		}

		return $content;
	}
}
