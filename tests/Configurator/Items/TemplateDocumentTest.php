<?php

namespace akmaljp\DriveMaru\Tests\Configurator\Items;

use akmaljp\DriveMaru\Configurator\Items\Template;
use akmaljp\DriveMaru\Tests\Test;

/**
* @covers akmaljp\DriveMaru\Configurator\Items\TemplateDocument
*/
class TemplateDocumentTest extends Test
{
	/**
	* @testdox saveChanges() updates the document's original template
	*/
	public function testSaveChanges()
	{
		$template = new Template('<hr/>');

		$dom = $template->asDOM();
		$dom->documentElement->firstChild->setAttribute('id', 'x');
		$dom->saveChanges();

		$this->assertEquals('<hr id="x"/>', $template);
	}
}