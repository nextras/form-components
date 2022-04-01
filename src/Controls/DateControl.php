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
	
	/** @var array */
	private $time = [0, 0, 0, 0];

	
	public function setTime(int $h, int $m = 0, int $s = 0, int $ms = 0): self
	{
		if ($h < 0 || $h > 23
			|| $m < 0 || $m > 59
			|| $s < 0 || $s > 59
			|| $ms < 0 || $ms > 999999
		) {
			throw new InvalidArgumentException('Please set valid time');
		}
		$this->time = [$h, $m, $s, $ms];
		return $this;
	}


	/**
	 * Suitable for usage with datetime field in database
	 */
	public function setLatestTime(bool $useMicroSeconds = false): self
	{
		return $this->setTime(23, 59, 59, $useMicroSeconds ? 999999 : 0);
	}
	
	
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
				->setTime(...$this->time);
		};
	}


	/**
	 * @return DateTimeImmutable|null
	 */
	public function getValue()
	{
		$val = parent::getValue();
		// set time so the limit dates (min & max) pass the :RANGE validation rule
		if ($val !== null) {
			return $val->setTime(...$this->time);
		}
		return $val;
	}
}
