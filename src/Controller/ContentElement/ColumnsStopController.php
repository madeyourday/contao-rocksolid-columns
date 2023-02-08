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
 * Columns stop content element
 *
 * @author Martin Auswöger <martin@madeyourday.net>
 *
 * @ContentElement("rs_columns_stop", category="rs_columns")
 */
class ColumnsStopController extends AbstractContentElementController
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
			return new Response($backendTemplate->parse());
		}

		$parentKey = ($model->ptable ?: 'tl_article') . '__' . $model->pid;

		if (isset($GLOBALS['TL_RS_COLUMNS'][$parentKey])) {
			if (!$GLOBALS['TL_RS_COLUMNS'][$parentKey]['active']) {
				trigger_error('Missing column stop element before column wrapper stop element ID ' . $model->id . '.', E_USER_WARNING);
			}
			unset($GLOBALS['TL_RS_COLUMNS'][$parentKey]);
		}
		else {
			trigger_error('Missing column wrapper start element before column wrapper stop element ID ' . $model->id . '.', E_USER_WARNING);
		}

		$htmlSuffix = '';

		if (!empty($GLOBALS['TL_RS_COLUMNS_STACK'][$parentKey])) {
			$GLOBALS['TL_RS_COLUMNS'][$parentKey] = array_pop($GLOBALS['TL_RS_COLUMNS_STACK'][$parentKey]);
			if ($GLOBALS['TL_RS_COLUMNS'][$parentKey]['active']) {
				$htmlSuffix .= '</div>';
			}
		}

		return new Response($template->parse() . $htmlSuffix);
	}

}
