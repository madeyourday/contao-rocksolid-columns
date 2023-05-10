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
use Contao\CoreBundle\Image\Studio\Studio;
use Contao\CoreBundle\Routing\ScopeMatcher;
use Contao\CoreBundle\ServiceAnnotation\ContentElement;
use Contao\StringUtil;
use Contao\Template;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Column start content element
 *
 * @author Martin Auswöger <martin@madeyourday.net>
 *
 * @ContentElement("rs_column_start", category="rs_columns")
 */
class ColumnStartController extends AbstractContentElementController
{
	private ScopeMatcher $scopeMatcher;
    private Studio $studio;

    public function __construct(ScopeMatcher $scopeMatcher, Studio $studio)
	{
		$this->scopeMatcher = $scopeMatcher;
        $this->studio = $studio;
    }

	protected function getResponse(Template $template, ContentModel $model, Request $request): ?Response
	{
		if ($this->scopeMatcher->isBackendRequest($request)) {
			$backendTemplate = new BackendTemplate('be_wildcard');
			$backendTemplate->title = $template->headline;
			return new Response($backendTemplate->parse());
		}

		$classes = array('rs-column');
		$styles = array();
		$parentKey = ($model->ptable ?: 'tl_article') . '__' . $model->pid;

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
			trigger_error('Missing column wrapper start element before column start element ID ' . $model->id . '.', E_USER_WARNING);
		}

		if ($model->rs_column_color_inverted) {
			$classes[] = '-color-inverted';
		}

		if ($model->rs_column_background) {

			$backgroundColor = StringUtil::deserialize($model->rs_column_background_color);
			if (is_array($backgroundColor) && $backgroundColor[0]) {
				$styles[] = 'background-color: #' . $backgroundColor[0] . ';';
			}

			if (trim($model->rs_column_background_image)) {
                $figure = $this->studio
                    ->createFigureBuilder()
                    ->fromUuid($model->rs_column_background_image ?: '')
                    ->setSize($model->rs_column_background_image_size)
                    ->enableLightbox(false)
                    ->buildIfResourceExists()
                ;
                if (null !== $figure) {
                    $styles[] = 'background-image: url(&quot;' . $figure->getImage()->getImageSrc(true) . '&quot;);';
                }
			}

			if ($model->rs_column_background_size) {
				$styles[] = 'background-size: ' . $model->rs_column_background_size . ';';
			}

			if ($model->rs_column_background_position) {
				$styles[] = 'background-position: ' . $model->rs_column_background_position . ';';
			}

			if ($model->rs_column_background_repeat) {
				$styles[] = 'background-repeat: ' . $model->rs_column_background_repeat . ';';
			}

		}

		$template->class .= ' ' . implode(' ', $classes);
		$template->style = implode(' ', $styles);

		return new Response($template->parse());
	}
}
