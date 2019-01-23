<?php

namespace akmaljp\DriveMaru\Tests\Configurator\Bundles;

use akmaljp\DriveMaru\Configurator\Bundles\Forum;
use akmaljp\DriveMaru\Tests\Test;

/**
* @covers akmaljp\DriveMaru\Configurator\Bundles\Forum
*/
class ForumTest extends Test
{
	/**
	* @testdox Features
	*/
	public function testFeatures()
	{
		$configurator = Forum::getConfigurator();

		$this->assertTrue(isset($configurator->Autoemail));
		$this->assertTrue(isset($configurator->Autolink));

		$this->assertTrue($configurator->BBCodes->exists('B'));
		$this->assertTrue($configurator->BBCodes->exists('CENTER'));
		$this->assertTrue($configurator->BBCodes->exists('CODE'));
		$this->assertTrue($configurator->BBCodes->exists('COLOR'));
		$this->assertTrue($configurator->BBCodes->exists('EMAIL'));
		$this->assertTrue($configurator->BBCodes->exists('FONT'));
		$this->assertTrue($configurator->BBCodes->exists('I'));
		$this->assertTrue($configurator->BBCodes->exists('LIST'));
		$this->assertTrue($configurator->BBCodes->exists('*'));
		$this->assertTrue($configurator->BBCodes->exists('LI'));
		$this->assertTrue($configurator->BBCodes->exists('QUOTE'));
		$this->assertTrue($configurator->BBCodes->exists('S'));
		$this->assertTrue($configurator->BBCodes->exists('SIZE'));
		$this->assertTrue($configurator->BBCodes->exists('SPOILER'));
		$this->assertTrue($configurator->BBCodes->exists('U'));
		$this->assertTrue($configurator->BBCodes->exists('URL'));

		$this->assertTrue($configurator->BBCodes->exists('MEDIA'));
		$this->assertTrue($configurator->BBCodes->exists('BANDCAMP'));
		$this->assertTrue($configurator->BBCodes->exists('DAILYMOTION'));
		$this->assertTrue($configurator->BBCodes->exists('FACEBOOK'));
		$this->assertTrue($configurator->BBCodes->exists('INDIEGOGO'));
		$this->assertTrue($configurator->BBCodes->exists('INSTAGRAM'));
		$this->assertTrue($configurator->BBCodes->exists('KICKSTARTER'));
		$this->assertTrue($configurator->BBCodes->exists('LIVELEAK'));
		$this->assertTrue($configurator->BBCodes->exists('SOUNDCLOUD'));
		$this->assertTrue($configurator->BBCodes->exists('TWITCH'));
		$this->assertTrue($configurator->BBCodes->exists('VIMEO'));
		$this->assertTrue($configurator->BBCodes->exists('VINE'));
		$this->assertTrue($configurator->BBCodes->exists('WSHH'));
		$this->assertTrue($configurator->BBCodes->exists('YOUTUBE'));
	}
}