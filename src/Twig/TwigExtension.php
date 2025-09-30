<?php

namespace MadeYourDay\RockSolidColumns\Twig;

use Contao\CoreBundle\Image\Studio\Figure;
use Contao\CoreBundle\Image\Studio\Studio;
use Contao\FilesModel;
use Contao\Image\ImageInterface;
use Contao\ImagineSvg\Imagine;
use MadeYourDay\RockSolidColumns\Element\ColumnsStart;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Twig\TwigFunction;

final class TwigExtension extends AbstractExtension
{
	public function getFunctions(): array
	{
		return [
			new TwigFunction(
				'rsc_wrapper_class',
				function ($context, array|object|null $data = null): string {
					if ($data instanceof \Traversable) {
						$data = iterator_to_array($data);
					}

					return ColumnsStart::getWrapperClassName(array_merge((array) $context, (array) $data));
				},
				['needs_context' => true],
			),
			new TwigFunction(
				'rsc_class',
				function ($context, int|null $index = null, array|object|null $data = null): string {
					if ($data instanceof \Traversable) {
						$data = iterator_to_array($data);
					}

					$index ??= $context['loop']['index0'] ?? $context['_key'] ?? $context['key'] ?? $context['index'] ?? 0;

					$config = ColumnsStart::getColumnsConfiguration(array_merge((array) $context, (array) $data));

					$classes = ['rs-column'];
					foreach ($config as $name => $media) {
						$classes = array_merge($classes, $media[$index % count($media)]);
						if ($index < count($media)) {
							$classes[] = '-' . $name . '-first-row';
						}
					}

					return implode(' ', $classes);
				},
				['needs_context' => true],
			),
			new TwigFunction(
				'rsc_grid_styles',
				function ($context, array|object|null $data = null): array {
					if ($data instanceof \Traversable) {
						$data = iterator_to_array($data);
					}

					return ColumnsStart::getColumnsGridStyles(array_merge((array) $context, (array) $data));
				},
				['needs_context' => true],
			),
		];
	}
}
