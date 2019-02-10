<?php declare(strict_types = 1);

namespace NextrasDemos\FormsComponents\Datetime;

use Nette\Application\UI\Form;
use Nette\Application\UI\Presenter;
use Nextras\FormComponents\Controls\DateControl;
use Nextras\FormComponents\Controls\DateTimeControl;


class DatetimePresenter extends Presenter
{
	public function actionDefault()
	{
	}


	public function createComponentForm()
	{
		$form = new Form();
		$form['date'] = new DateControl('Born');
		$form['registered'] = new DateTimeControl('Registered');
		$form->addSubmit('save', 'Send');
		$form->onSuccess[] = function ($form, $values) {
			dump($values);
		};
		return $form;
	}


	public function formatTemplateFiles(): array
	{
		return [__DIR__ . '/DatetimePresenter.latte'];
	}
}
