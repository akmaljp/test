<?php

namespace akmaljp\DriveMaru\Tests\Plugins\MediaEmbed\Configurator\TemplateGenerators;

use akmaljp\DriveMaru\Plugins\MediaEmbed\Configurator\TemplateGenerators\Flash;

/**
* @covers akmaljp\DriveMaru\Plugins\MediaEmbed\Configurator\TemplateGenerator
* @covers akmaljp\DriveMaru\Plugins\MediaEmbed\Configurator\TemplateGenerators\Flash
*/
class FlashTest extends AbstractTest
{
	protected function getTemplateGenerator()
	{
		return new Flash;
	}

	public function getGetTemplateTests()
	{
		return [
			[
				[
					'src' => '/embed/{@id}'
				],
				'<span style="display:inline-block;width:100%;max-width:640px"><span style="display:block;overflow:hidden;position:relative;padding-bottom:56.25%"><object data="/embed/{@id}" style="height:100%;left:0;position:absolute;width:100%" type="application/x-shockwave-flash" typemustmatch=""><param name="allowfullscreen" value="true"/></object></span></span>'
			],
			[
				[
					'flashvars' => 'a=1',
					'src'       => '/embed/{@id}'
				],
				'<span style="display:inline-block;width:100%;max-width:640px"><span style="display:block;overflow:hidden;position:relative;padding-bottom:56.25%"><object data="/embed/{@id}" style="height:100%;left:0;position:absolute;width:100%" type="application/x-shockwave-flash" typemustmatch=""><param name="allowfullscreen" value="true"/><param name="flashvars" value="a=1"/></object></span></span>'
			],
		];
	}
}