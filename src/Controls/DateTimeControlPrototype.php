<?php declare(strict_types = 1);

/**
 * This file is part of the Nextras community extensions of Nette Framework
 *
 * @license    MIT
 * @link       https://github.com/nextras/form-components
 */

namespace Nextras\FormComponents\Controls;

use DateTime;
use DateTimeImmutable;
use DateTimeInterface;
use Nette;
use Nette\Forms\Controls\TextBase;
use Nette\Forms\Form;
use Nette\Forms\Rules;
use Nette\Utils\Html;


abstract class DateTimeControlPrototype extends TextBase
{
	/** @var string */
	protected $htmlFormat;

	/** @var string */
	protected $htmlType;

	/** @var callable[] */
	protected $parsers = [];


	public function getControl(): Html
	{
		$control = parent::getControl();
		$control->type = $this->htmlType;
		$control->autocomplete('off');
		$control->addClass($this->htmlType);

		list($min, $max) = $this->extractRangeRule($this->getRules());
		if ($min instanceof DateTimeInterface) {
			$control->min = $min->format($this->htmlFormat);
		}
		if ($max instanceof DateTimeInterface) {
			$control->max = $max->format($this->htmlFormat);
		}
		$value = $this->getValue();
		if ($value instanceof DateTimeInterface) {
			$control->value = $value->format($this->htmlFormat);
		}

		return $control;
	}


	public function setValue($value)
	{
		return parent::setValue(
			$value instanceof DateTimeInterface
				? $value->format($this->htmlFormat)
				: $value
		);
	}


	/**
	 * @return DateTimeImmutable|null
	 */
	public function getValue()
	{
		if ($this->value instanceof DateTimeImmutable) {
			return $this->value;

		} elseif ($this->value instanceof DateTime) {
			return DateTimeImmutable::createFromMutable($this->value);

		} elseif (empty($this->value)) {
			return null;

		} elseif (is_string($this->value)) {
			$parsers = $this->parsers;
			$parsers[] = $this->getDefaultParser();

			foreach ($parsers as $parser) {
				$value = call_user_func($parser, $this->value);
				if ($value instanceof DateTimeImmutable) {
					return $value;
				} elseif ($value instanceof DateTime) {
					return DateTimeImmutable::createFromMutable($value);
				}
			}

			// fall-through
		}

		return null;
	}


	public function addParser(callable $parser)
	{
		$this->parsers[] = $parser;
		return $this;
	}


	abstract protected function getDefaultParser();


	/**
	 * Finds minimum and maximum allowed dates.
	 *
	 * @return array 0 => DateTime|null $minDate, 1 => DateTime|null $maxDate
	 */
	protected function extractRangeRule(Rules $rules)
	{
		$controlMin = $controlMax = null;
		/** @var Nette\Forms\Rule $rule */
		foreach ($rules as $rule) {
			$ruleMin = $ruleMax = null;

			/** @var Rules|null $branch */
			$branch = $rule->branch;
			if ($branch === null) {
				if (!$rule->isNegative) {
					if ($rule->validator === Form::MIN) {
						$ruleMin = $rule->arg;
					} elseif ($rule->validator === Form::MAX) {
						$ruleMax = $rule->arg;
					} elseif ($rule->validator === Form::RANGE) {
						list($ruleMin, $ruleMax) = $rule->arg;
					}
				}
			} else {
				if ($rule->validator === Form::FILLED && !$rule->isNegative && $rule->control === $this) {
					list($ruleMin, $ruleMax) = $this->extractRangeRule($branch);
				}
			}

			if ($ruleMin !== null && ($controlMin === null || $ruleMin > $controlMin)) {
				$controlMin = $ruleMin;
			}
			if ($ruleMax !== null && ($controlMax === null || $ruleMax < $controlMax)) {
				$controlMax = $ruleMax;
			}
		}
		return [$controlMin, $controlMax];
	}
}
