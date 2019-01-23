<?php

namespace akmaljp\DriveMaru\Tests\Configurator\TemplateNormalizations;

/**
* @covers akmaljp\DriveMaru\Configurator\TemplateNormalizations\ConvertCurlyExpressionsInText
*/
class ConvertCurlyExpressionsInTextTest extends AbstractTest
{
	public function getData()
	{
		return [
			[
				'<span>{$FOO}{@bar}</span>',
				'<span><xsl:value-of select="$FOO"/><xsl:value-of select="@bar"/></span>'
			],
			[
				'0<span>1{$FOO}2{@bar}3</span>4',
				'0<span>1<xsl:value-of select="$FOO"/>2<xsl:value-of select="@bar"/>3</span>4'
			],
			[
				// Text inside of XSL elements is ignored
				'<span><xsl:text>{$FOO}{@bar}</xsl:text></span>',
				'<span><xsl:text>{$FOO}{@bar}</xsl:text></span>'
			],
			[
				// Only single variables and attributes are accepted
				'<script>if (foo) { alert($BAR); }</script>',
				'<script>if (foo) { alert($BAR); }</script>'
			],
		];
	}
}