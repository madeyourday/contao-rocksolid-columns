<?php
/*
 * Copyright MADE/YOUR/DAY OG <mail@madeyourday.net>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace MadeYourDay\RockSolidColumns;

use MadeYourDay\RockSolidColumns\DependencyInjection\RockSolidColumnsExtension;
use Symfony\Component\DependencyInjection\Extension\ExtensionInterface;
use Symfony\Component\HttpKernel\Bundle\Bundle;

/**
 * Configures the RockSolid Columns bundle.
 *
 * @author Martin Auswöger <martin@madeyourday.net>
 */
class RockSolidColumnsBundle extends Bundle
{
	/**
	 * {@inheritdoc}
	 */
	public function getContainerExtension(): ?ExtensionInterface
	{
		return new RockSolidColumnsExtension();
	}
}
