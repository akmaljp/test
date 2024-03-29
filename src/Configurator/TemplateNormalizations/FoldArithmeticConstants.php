<?php

/**
* @package   akmaljp\DriveMaru
* @copyright Copyright (c) 2010-2019 The akmaljp Authors
* @license   http://www.opensource.org/licenses/mit-license.php The MIT License
*/
namespace akmaljp\DriveMaru\Configurator\TemplateNormalizations;

use akmaljp\DriveMaru\Utils\XPath;

class FoldArithmeticConstants extends AbstractConstantFolding
{
	/**
	* {@inheritdoc}
	*/
	protected function getOptimizationPasses()
	{
		// Regular expression matching a number
		$n = '-?\\.\\d++|-?\\d++(?:\\.\\d++)?';

		return [
			'(^[-+0-9\\s]+$)'                                            => 'foldOperation',
			'( \\+ 0(?! [^+\\)])|(?<![-\\w])0 \\+ )'                     => 'foldAdditiveIdentity',
			'(^((?>' . $n . ' [-+] )*)(' . $n . ') div (' . $n . '))'    => 'foldDivision',
			'(^((?>' . $n . ' [-+] )*)(' . $n . ') \\* (' . $n . '))'    => 'foldMultiplication',
			'(\\( (?:' . $n . ') (?>(?>[-+*]|div) (?:' . $n . ') )+\\))' => 'foldSubExpression',
			'((?<=[-+*\\(]|\\bdiv|^) \\( ([@$][-\\w]+|' . $n . ') \\) (?=[-+*\\)]|div|$))' => 'removeParentheses'
		];
	}

	/**
	* {@inheritdoc}
	*/
	protected function evaluateExpression($expr)
	{
		$expr = preg_replace_callback(
			'(([\'"])(.*?)\\1)s',
			function ($m)
			{
				return $m[1] . bin2hex($m[2]) . $m[1];
			},
			$expr
		);
		$expr = parent::evaluateExpression($expr);
		$expr = preg_replace_callback(
			'(([\'"])(.*?)\\1)s',
			function ($m)
			{
				return $m[1] . hex2bin($m[2]) . $m[1];
			},
			$expr
		);

		return $expr;
	}

	/**
	* Remove "+ 0" additions
	*
	* @param  array  $m
	* @return string
	*/
	protected function foldAdditiveIdentity(array $m)
	{
		return '';
	}

	/**
	* Evaluate and return the result of a division
	*
	* @param  array  $m
	* @return string
	*/
	protected function foldDivision(array $m)
	{
		return $m[1] . XPath::export($m[2] / $m[3]);
	}

	/**
	* Evaluate and return the result of a multiplication
	*
	* @param  array  $m
	* @return string
	*/
	protected function foldMultiplication(array $m)
	{
		return $m[1] . XPath::export($m[2] * $m[3]);
	}

	/**
	* Evaluate and replace a constant operation
	*
	* @param  array  $m
	* @return string
	*/
	protected function foldOperation(array $m)
	{
		return XPath::export($this->xpath->evaluate($m[0]));
	}

	/**
	* Evaluate and return the result of a simple subexpression
	*
	* @param  array  $m
	* @return string
	*/
	protected function foldSubExpression(array $m)
	{
		return '(' . $this->evaluateExpression(trim(substr($m[0], 1, -1))) . ')';
	}

	/**
	* Remove the parentheses around an integer
	*
	* @param  array  $m
	* @return string
	*/
	protected function removeParentheses(array $m)
	{
		return ' ' . $m[1] . ' ';
	}
}