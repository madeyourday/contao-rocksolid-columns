<?php
/*
 * Copyright MADE/YOUR/DAY OG <mail@madeyourday.net>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace MadeYourDay\RockSolidColumns\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;

final class RockSolidColumnsExtension extends Extension
{
	public function load(array $configs, ContainerBuilder $container): void
	{
		(new YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config')))
			->load('services.yaml')
		;
	}
}
