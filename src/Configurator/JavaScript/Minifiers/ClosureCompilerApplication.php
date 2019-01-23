<?php

/**
* @package   akmaljp\DriveMaru
* @copyright Copyright (c) 2010-2019 The akmaljp Authors
* @license   http://www.opensource.org/licenses/mit-license.php The MIT License
*/
namespace akmaljp\DriveMaru\Configurator\JavaScript\Minifiers;

use RuntimeException;
use akmaljp\DriveMaru\Configurator\JavaScript\Minifier;

class ClosureCompilerApplication extends Minifier
{
	/**
	* @var string Path to the Closure Compiler application
	* @deprecated 1.3.0 Set a command instead
	*/
	public $closureCompilerBin;

	/**
	* @var string Command used to invoke the Closure Compiler application
	*/
	public $command;

	/**
	* @var string Closure Compiler's compilation level
	*/
	public $compilationLevel = 'ADVANCED_OPTIMIZATIONS';

	/**
	* @var bool Whether to exclude Closure Compiler's default externs
	*/
	public $excludeDefaultExterns = true;

	/**
	* @var string Path to java interpreter
	* @deprecated 1.3.0 Set a command instead
	*/
	public $javaBin = 'java';

	/**
	* @var string Extra options to be passed to the Closure Compiler application
	*/
	public $options = '--use_types_for_optimization';

	/**
	* Constructor
	*
	* @param  string $filepathOrCommand Path to the Closure Compiler .jar or command to execute
	*/
	public function __construct($filepathOrCommand = null)
	{
		if (isset($filepathOrCommand))
		{
			if (file_exists($filepathOrCommand) && substr($filepathOrCommand, -4) === '.jar')
			{
				$this->closureCompilerBin = $filepathOrCommand;
			}
			else
			{
				$this->command = $filepathOrCommand;
			}
		}
	}

	/**
	* {@inheritdoc}
	*/
	public function getCacheDifferentiator()
	{
		$key = [
			$this->compilationLevel,
			$this->excludeDefaultExterns,
			$this->options
		];
		if (isset($this->closureCompilerBin))
		{
			$key[] = $this->getClosureCompilerBinHash();
		}

		if ($this->excludeDefaultExterns)
		{
			$key[] = file_get_contents(__DIR__ . '/../externs.application.js');
		}

		return $key;
	}

	/**
	* Compile given JavaScript source via the Closure Compiler application
	*
	* @param  string $src JavaScript source
	* @return string      Compiled source
	*/
	public function minify($src)
	{
		$this->testFilepaths();
		$options = ($this->options) ? ' ' . $this->options : '';

		// Add our custom externs if default externs are disabled
		if ($this->excludeDefaultExterns && $this->compilationLevel === 'ADVANCED_OPTIMIZATIONS')
		{
			$options .= ' --externs ' . __DIR__ . '/../externs.application.js --env=CUSTOM';
		}

		$crc     = crc32($src);
		$inFile  = sys_get_temp_dir() . '/' . $crc . '.js';
		$outFile = sys_get_temp_dir() . '/' . $crc . '.min.js';

		file_put_contents($inFile, $src);

		if (isset($this->command))
		{
			$cmd = $this->command;
		}
		else
		{
			$cmd = escapeshellcmd($this->javaBin) . ' -jar ' . escapeshellarg($this->closureCompilerBin);
		}

		$cmd .= ' --compilation_level ' . escapeshellarg($this->compilationLevel)
		     . $options
		     . ' --js ' . escapeshellarg($inFile)
		     . ' --js_output_file ' . escapeshellarg($outFile);

		exec($cmd . ' 2>&1', $output, $return);
		unlink($inFile);

		if (file_exists($outFile))
		{
			$src = trim(file_get_contents($outFile));
			unlink($outFile);
		}

		if (!empty($return))
		{
			throw new RuntimeException('An error occured during minification: ' . implode("\n", $output));
		}

		return $src;
	}

	/**
	* Compute and return the hash for current Closure Compiler binary
	*
	* @return string
	*/
	protected function getClosureCompilerBinHash()
	{
		// Caching the value saves time during testing but has little to no real-world impact
		static $cache = [];
		if (!isset($cache[$this->closureCompilerBin]))
		{
			$cache[$this->closureCompilerBin] = md5_file($this->closureCompilerBin);
		}

		return $cache[$this->closureCompilerBin];
	}

	/**
	* Test that the Closure Compiler file exists
	*
	* @return void
	*/
	protected function testFilepaths()
	{
		if (isset($this->command))
		{
			return;
		}
		if (!isset($this->closureCompilerBin))
		{
			throw new RuntimeException('No path set for Closure Compiler');
		}
		if (!file_exists($this->closureCompilerBin))
		{
			throw new RuntimeException('Cannot find Closure Compiler at ' . $this->closureCompilerBin);
		}
	}
}