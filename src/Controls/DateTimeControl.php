<?php declare(strict_types = 1);

/**
 * This file is part of the Nextras community extensions of Nette Framework
 *
 * @license    MIT
 * @link       https://github.com/nextras/form-components
 */

namespace Nextras\FormComponents\Controls;

use DateTimeImmutable;


class DateTimeControl extends DateTimeControlPrototype
{
	/** @link http://dev.w3.org/html5/spec/common-microsyntaxes.html#parse-a-local-date-and-time-string */
	protected const W3C_DATETIME_FORMAT = 'Y-m-d\TH:i:s';

	/** @var string */
	protected $htmlFormat = self::W3C_DATETIME_FORMAT;

	/** @var string */
	protected $htmlType = 'datetime-local';


	protected function getDefaultParser()
	{
		return function($value) {
			try {
				return new DateTimeImmutable($value);
			} catch (\Exception $e) {
				// fallback to custm parsing
			}

			if (!preg_match('#^(?P<dd>\d{1,2})[. -]\s*(?P<mm>\d{1,2})(?:[. -]\s*(?P<yyyy>\d{4})?)?(?:\s*[ @-]\s*(?P<hh>\d{1,2})[:.](?P<ii>\d{1,2})(?:[:.](?P<ss>\d{1,2}))?)?$#', $value, $matches)) {
				return null;
			}

			$dd = (int) $matches['dd'];
			$mm = (int) $matches['mm'];
			$yyyy = (int) ($matches['yyyy'] ?? date('Y'));

			if (!checkdate($mm, $dd, $yyyy)) {
				return null;
			}

			$hh = (int) ($matches['hh'] ?? 0);
			$ii = (int) ($matches['ii'] ?? 0);
			$ss = (int) ($matches['ss'] ?? 0);

			if (!($hh >= 0 && $hh < 24 && $ii >= 0 && $ii <= 59 && $ss >= 0 && $ss <= 59)) {
				return null;
			}

			return (new DateTimeImmutable())
				->setDate($yyyy, $mm, $dd)
				->setTime($hh, $ii, $ss);
		};
	}
}
