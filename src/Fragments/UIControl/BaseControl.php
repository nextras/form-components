<?php declare(strict_types = 1);

/**
 * This file is part of the Nextras community extensions of Nette Framework
 *
 * @license    MIT
 * @link       https://github.com/nextras/form-components
 */

namespace Nextras\FormComponents\Fragments\UIControl;

use Nette\Application\UI\Control;
use Nette\ComponentModel\Container;
use Nette\ComponentModel\IComponent;
use Nextras\FormComponents\Fragments\Traits\BaseControlTrait;


abstract class BaseControl extends Control implements \Nette\Forms\Control
{
	use BaseControlTrait;


	protected function createComponent(string $name): ?IComponent
	{
		// skip the warning trigger that component is not intended to be used in the Presenter
		return Container::createComponent($name);
	}
}
