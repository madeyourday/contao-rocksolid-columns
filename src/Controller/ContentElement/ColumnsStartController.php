<?php
/*
 * Copyright MADE/YOUR/DAY OG <mail@madeyourday.net>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace MadeYourDay\RockSolidColumns\Controller\ContentElement;

use Contao\BackendTemplate;
use Contao\ContentModel;
use Contao\CoreBundle\Controller\ContentElement\AbstractContentElementController;
use Contao\CoreBundle\Routing\ScopeMatcher;
use Contao\CoreBundle\ServiceAnnotation\ContentElement;
use Contao\Template;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Columns start content element
 *
 * @author Martin Auswöger <martin@madeyourday.net>
 *
 * @ContentElement("rs_columns_start", category="rs_columns")
 */
class ColumnsStartController extends AbstractContentElementController
{
	private ScopeMatcher $scopeMatcher;

	public function __construct(ScopeMatcher $scopeMatcher)
	{
		$this->scopeMatcher = $scopeMatcher;
	}

	protected function getResponse(Template $template, ContentModel $model, Request $request): ?Response
	{
		if ($this->scopeMatcher->isBackendRequest($request)) {
			$backendTemplate = new BackendTemplate('be_wildcard');
			$backendTemplate->title = $template->headline;
			return new Response($backendTemplate->parse());
		}

		$parentKey = ($model->ptable ?: 'tl_article') . '__' . $model->pid;

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
			'config' => static::getColumnsConfiguration($model->row()),
		);

		$template->class .= ' ' . static::getWrapperClassName($model->row());

		return new Response($htmlPrefix . $template->parse());
	}

	/**
	 * Generate the columns configuration
	 *
	 * @param  array $data Data array
	 * @return array       Columns configuration
	 */
	public static function getColumnsConfiguration(array $data): array
	{
		$config = array();
		$lastColumns = null;

		// Backwards compatibility
		if (empty($data['rs_columns_xlarge']) && !empty($data['rs_columns_large'])) {
			$data['rs_columns_xlarge'] = $data['rs_columns_large'];
		}

		foreach (array('xlarge', 'large', 'medium', 'small', 'xsmall') as $media) {

			$columns = $data['rs_columns_'.$media] ?? null;
			if (!$columns) {
				$columns = $lastColumns ?: '2';
			}
			$lastColumns = $columns;

			$columns = array_map(static function($value) {
				return (int)$value ?: 1;
			}, explode('-', $columns));

			if (count($columns) === 1 && $columns[0] > 1) {
				$columns = array_fill(0, (int)$columns[0], '1');
			}

			$columnsTotal = array_reduce($columns, static function($a, $b) {
				return $a + $b;
			});
			$classes = array();
			foreach ($columns as $column) {
				$classes[] = array('-' . $media . '-col-' . $columnsTotal . '-' . $column);
			}
			$classes[0][] = '-' . $media . '-first';
			$classes[count($classes) - 1][] = '-' . $media . '-last';
			$config[$media] = $classes;

		}

		return $config;
	}

	/**
	 * Generate the wrapper class name
	 *
	 * @param  array $data Data array
	 * @return string      Wrapper class name
	 */
	public static function getWrapperClassName(array $data): string
	{
		$classes = array('rs-columns');

		if (!empty($data['rs_columns_outside_gutters'])) {
			$classes[] = '-outside-gutters';
		}

		if (!empty($data['rs_columns_equal_height'])) {
			$classes[] = '-equal-height';
		}

		if (!empty($data['rs_columns_gutter'])) {
			$classes[] = '-gutter-' . $data['rs_columns_gutter'];
		}

		return implode(' ', $classes);
	}
}
