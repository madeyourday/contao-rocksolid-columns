<?php
/*
 * Copyright MADE/YOUR/DAY OG <mail@madeyourday.net>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace MadeYourDay\RockSolidColumns\EventListener\DataContainer;

use Contao\CoreBundle\Routing\ScopeMatcher;
use Contao\CoreBundle\ServiceAnnotation\Hook;
use Contao\System;
use Symfony\Component\HttpFoundation\RequestStack;

/**
 * @Hook("loadDataContainer")
 */
class AddBackendAssetsListener
{
	private RequestStack $requestStack;
	private ScopeMatcher $scopeMatcher;

	public function __construct(RequestStack $requestStack, ScopeMatcher $scopeMatcher)
	{
		$this->requestStack = $requestStack;
		$this->scopeMatcher = $scopeMatcher;
	}

	public function __invoke(string $table): void
	{
		if ('tl_content' !== $table && 'tl_form_field' !== $table) {
			return;
		}

		$request = $this->requestStack->getCurrentRequest();

		if (null === $request || !$this->scopeMatcher->isBackendRequest($request)) {
			return;
		}

		$GLOBALS['TL_CSS'][] = 'bundles/rocksolidcolumns/css/be_main.css';

		if ('tl_form_field' === $table) {
			System::loadLanguageFile('tl_content');
		}
	}
}
