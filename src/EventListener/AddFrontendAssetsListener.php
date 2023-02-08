<?php
/*
 * Copyright MADE/YOUR/DAY OG <mail@madeyourday.net>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace MadeYourDay\RockSolidColumns\EventListener;

use Contao\CoreBundle\ServiceAnnotation\Hook;
use Contao\PageRegular;
use Contao\LayoutModel;
use Contao\PageModel;

/**
 * @Hook("generatePage")
 */
class AddFrontendAssetsListener
{
    public function __invoke(PageModel $pageModel, LayoutModel $layout, PageRegular $pageRegular): void
    {
        if ($layout->rs_columns_load_css) {
            $GLOBALS['TL_CSS'][] = 'bundles/rocksolidcolumns/css/columns.css||static';
        }
    }
}
