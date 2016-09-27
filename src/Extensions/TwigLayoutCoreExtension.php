<?php //strict

namespace LayoutCore\Extensions;

use Plenty\Plugin\Templates\Extensions\Twig_Extension;
use Plenty\Plugin\Templates\Extensions\Twig_SimpleFunction;
use Plenty\Plugin\Templates\Extensions\Twig_SimpleFilter;
use Plenty\Plugin\Templates\Factories\TwigFactory;

use LayoutCore\Extensions\AbstractFilter;
use LayoutCore\Extensions\AbstractFunction;
use LayoutCore\Extensions\Filters\PatternFilter;
use LayoutCore\Extensions\Filters\NumberFormatFilter;
use LayoutCore\Extensions\Filters\URLFilter;
use LayoutCore\Extensions\Filters\ItemNameFilter;

use LayoutCore\Extensions\Functions\GetBasePrice;
use LayoutCore\Extensions\Functions\Component;

/**
 * Provide services and helper functions to twig engine
 */
class TwigLayoutCoreExtension extends Twig_Extension
{
	/**
	 * @var TwigFactory
	 */
	private $twig;

	public function __construct(
		TwigFactory $twig,
		PatternFilter $patternFilter,
		NumberFormatFilter $numberFormatFilter,
		URLFilter $urlFilter,
		GetBasePrice $getBasePrice,
		Component $component
	)
	{
		$this->twig = $twig;
	}

	/**
	 * Returns the name of the extension. Must be unique.
	 *
	 * @return string The name of the extension
	 */
	public function getName():string
	{
		return "LayoutCore_Extension_TwigLayoutCoreExtensions";
	}

	/**
	 * Returns a list of filters to add.
	 *
	 * @return array The list of filters to add.
	 */
	public function getFilters():array
	{
		$filters = [];
		foreach(AbstractFilter::$filters as $abstractFilter)
		{
			foreach($abstractFilter->getFilters() as $filterName => $callable)
			{
				array_push(
					$filters,
					$this->twig->createSimpleFilter($filterName, [$abstractFilter, $callable])
				);
			}
		}
		return $filters;
	}

	/**
	 * Returns a list of functions to add.
	 *
	 * @return array the list of functions to add.
	 */
	public function getFunctions():array
	{
		$functions = [];
		foreach(AbstractFunction::$functions as $abstractFunction)
		{
			foreach($abstractFunction->getFunctions() as $functionName => $callable)
			{
				array_push(
					$functions,
					$this->twig->createSimpleFunction($functionName, [$abstractFunction, $callable])
				);
			}
		}
		return $functions;
	}
}