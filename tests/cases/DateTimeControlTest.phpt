<?php declare(strict_types = 1);

/** @testcase */

namespace NextrasTests\FormComponents\Controls;

use DateTime;
use DateTimeImmutable;
use Nextras\FormComponents\Controls\DateControl;
use Nextras\FormComponents\Controls\DateTimeControl;
use Tester\Assert;
use Tester\TestCase;
use Nette;

require_once __DIR__ . '/../bootstrap.php';


class DateTimeControlTest extends TestCase
{
	public function testNetteRule()
	{
		$dateTimePicker = new DateTimeControl();
		$dateTimePicker->setRequired();

		$form = new Nette\Forms\Form;
		$form->addComponent($dateTimePicker, 'dateTimePicker');

		$rule = new Nette\Forms\Rules($dateTimePicker);

		Assert::notSame(
			Nette\Forms\Helpers::exportRules($rule),
			$dateTimePicker->getControl()->getAttribute('data-nette-rules')
		);

		$rule->setRequired();

		Assert::same(
			Nette\Forms\Helpers::exportRules($rule),
			$dateTimePicker->getControl()->getAttribute('data-nette-rules')
		);
	}

	public function testDateTimeReturn()
	{
		$dateTimePicker_emptyValue = new DateTimeControl();
		Assert::null($dateTimePicker_emptyValue->getValue());

		$dateTimePicker_stringValue = new DateTimeControl();
		$dateTimePicker_stringValue->setValue('2018-01-01 06:00:00');

		Assert::type(DateTimeImmutable::class, $dateTimePicker_stringValue->getValue());
		Assert::equal(new DateTimeImmutable('2018-01-01 06:00:00'), $dateTimePicker_stringValue->getValue());

		$dateTimePicker_dateTimeValue = new DateTimeControl();
		$dateTimePicker_dateTimeValue->setValue(new DateTime('2018-01-01 06:00:00'));

		Assert::type(DateTimeImmutable::class, $dateTimePicker_dateTimeValue->getValue());
		Assert::equal(new DateTimeImmutable('2018-01-01 06:00:00'), $dateTimePicker_dateTimeValue->getValue());

		$dateTimePicker_dateTimeImmutableValue = new DateTimeControl();
		$dateTimePicker_dateTimeImmutableValue->setValue(new DateTimeImmutable('2018-01-01 06:00:00'));

		Assert::type(DateTimeImmutable::class, $dateTimePicker_dateTimeImmutableValue->getValue());
		Assert::equal(new DateTimeImmutable('2018-01-01 06:00:00'), $dateTimePicker_dateTimeImmutableValue->getValue());
	}

	public function testDateReturn()
	{
		$datePicker_emptyValue = new DateControl();
		Assert::null($datePicker_emptyValue->getValue());

		$datePicker_stringValue = new DateControl();
		$datePicker_stringValue->setValue('2018-01-01 06:00:00');

		Assert::type(DateTimeImmutable::class, $datePicker_stringValue->getValue());
		Assert::equal(new DateTimeImmutable('2018-01-01 00:00:00'), $datePicker_stringValue->getValue());

		$datePicker_dateTimeValue = new DateControl();
		$datePicker_dateTimeValue->setValue(new DateTime('2018-01-01 06:00:00'));

		Assert::type(DateTimeImmutable::class, $datePicker_dateTimeValue->getValue());
		Assert::equal(new DateTimeImmutable('2018-01-01 00:00:00'), $datePicker_dateTimeValue->getValue());

		$datePicker_dateTimeImmutableValue = new DateControl();
		$datePicker_dateTimeImmutableValue->setValue(new DateTimeImmutable('2018-01-01 06:00:00'));

		Assert::type(DateTimeImmutable::class, $datePicker_dateTimeImmutableValue->getValue());
		Assert::equal(new DateTimeImmutable('2018-01-01 00:00:00'), $datePicker_dateTimeImmutableValue->getValue());
	}
}


$test = new DateTimeControlTest();
$test->run();
