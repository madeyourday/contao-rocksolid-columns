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
 * Column stop content element
 *
 * @author Martin Auswöger <martin@madeyourday.net>
 *
 * @ContentElement("rs_column_stop", category="rs_columns")
 */
class ColumnStopController extends AbstractContentElementController
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

		if (isset($GLOBALS['TL_RS_COLUMNS'][$parentKey]) && !$GLOBALS['TL_RS_COLUMNS'][$parentKey]['active']) {
			$GLOBALS['TL_RS_COLUMNS'][$parentKey]['active'] = true;
		}
		else {
			trigger_error('Missing column start element before column stop element ID ' . $model->id . '.', E_USER_WARNING);
		}

		return new Response($template->parse());
	}
}
