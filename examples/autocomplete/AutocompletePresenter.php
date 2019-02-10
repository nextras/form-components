<?php declare(strict_types = 1);

namespace NextrasDemos\FormsComponents\Autocomplete;

use Nette\Application\UI\Form;
use Nette\Application\UI\Presenter;
use Nette\Utils\Strings;
use Nextras\FormComponents\Controls\AutocompleteControl;


class AutocompletePresenter extends Presenter
{
	private static $names = [
		'Olivia',
		'Oliver',
		'Amelia',
		'Harry',
		'Isla',
		'Jack',
		'Emily',
		'George',
		'Ava',
		'Noah',
		'Lily',
		'Charlie',
		'Mia',
		'Jacob',
		'Sophia',
		'Alfie',
		'Isabella',
		'Freddie',
		'Grace',
		'Oscar',
	];


	public function actionDefault()
	{
	}


	public function createComponentForm()
	{
		$form = new Form();
		$form['autocomplete'] = new AutocompleteControl(
			'Names',
			function (string $q) {
				return array_values(array_filter(self::$names, function ($name) use ($q) {
					return Strings::startsWith(strtolower($name), strtolower($q));
				}));
			}
		);
		return $form;
	}


	public function formatTemplateFiles(): array
	{
		return [__DIR__ . '/AutocompletePresenter.latte'];
	}
}
