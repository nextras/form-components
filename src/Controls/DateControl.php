<?php declare(strict_types = 1);

/**
 * This file is part of the Nextras community extensions of Nette Framework
 *
 * @license    MIT
 * @link       https://github.com/nextras/form-components
 */

namespace Nextras\FormComponents\Controls;

use DateTimeImmutable;


class DateControl extends DateTimeControlPrototype
{
	/** @link http://dev.w3.org/html5/spec/common-microsyntaxes.html#valid-date-string */
	protected const W3C_DATE_FORMAT = 'Y-m-d';

	/** @var string */
	protected $htmlFormat = self::W3C_DATE_FORMAT;

	/** @var string */
	protected $htmlType = 'date';


	protected function getDefaultParser()
	{
		return function($value) {
			try {
				return new DateTimeImmutable($value);
			} catch (\Exception $e) {
				// fallback to custm parsing
			}

			if (!preg_match('#^(?P<dd>\d{1,2})[. -]\s*(?P<mm>\d{1,2})([. -]\s*(?P<yyyy>\d{4})?)?$#', $value, $matches)) {
				return null;
			}

			$dd = (int) $matches['dd'];
			$mm = (int) $matches['mm'];
			$yyyy = (int) ($matches['yyyy'] ?? date('Y'));

			if (!checkdate($mm, $dd, $yyyy)) {
				return null;
			}

			return (new DateTimeImmutable())
				->setDate($yyyy, $mm, $dd)
				->setTime(0, 0, 0);
		};
	}


	/**
	 * @return DateTimeImmutable|null
	 */
	public function getValue()
	{
		$val = parent::getValue();
		// set the midnight so the limit dates (min & max) pass the :RANGE validation rule
		if ($val !== null) {
			return $val->setTime(0, 0, 0);
		}
		return $val;
	}
}
