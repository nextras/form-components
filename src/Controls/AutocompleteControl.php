<?php declare(strict_types = 1);

/**
 * This file is part of the Nextras community extensions of Nette Framework
 *
 * @license    MIT
 * @link       https://github.com/nextras/form-components
 */

namespace Nextras\FormComponents\Controls;

use Nette\Application\IPresenter;
use Nette\InvalidStateException;
use Nette\Utils\Html;
use Nextras\FormComponents\Fragments\UIControl\TextInput;


class AutocompleteControl extends TextInput
{
	/** @var callable|null */
	protected $callback;


	/**
	 * @param string|object $caption
	 */
	public function __construct($caption = null, ?callable $callback = null)
	{
		parent::__construct($caption);
		if ($callback) {
			$this->setCallback($callback);
		}
		$this->monitor(
			IPresenter::class,
			function () {
				$this->control->{'data-autocomplete-url'} = $this->link('autocomplete!', ['q' => '__QUERY_PLACEHOLDER__']);
			}
		);
	}


	public function getControl(): Html
	{
		$control = parent::getControl();
		$control->addClass('autocomplete');
		return $control;
	}


	public function setCallback(callable $callback)
	{
		$this->callback = $callback;
	}


	public function handleAutocomplete(string $q)
	{
		if (!$this->callback) {
			throw new InvalidStateException('Undefined autocomplete callback.');
		}

		$out = call_user_func($this->callback, $q);
		$presenter = $this->getPresenter();
		assert($presenter !== null);
		$presenter->sendJson($out);
	}
}
