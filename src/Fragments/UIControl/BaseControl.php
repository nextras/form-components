<?php declare(strict_types = 1);

/**
 * This file is part of the Nextras community extensions of Nette Framework
 *
 * @license    MIT
 * @link       https://github.com/nextras/form-components
 */

namespace Nextras\FormComponents\Fragments\UIControl;

use Nette\Application\UI\Control;
use Nette\Forms\IControl;
use Nextras\FormComponents\Fragments\Traits\BaseControlTrait;


abstract class BaseControl extends Control implements IControl
{
	use BaseControlTrait;
}
