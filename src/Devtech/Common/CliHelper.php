<?php
/**
 * Created by PhpStorm.
 * User: dejan.obradovic
 * Date: 6/30/14
 * Time: 2:09 PM
 */

namespace Devtech\Common;

class CliHelper {

	/**
	 * @var IValidator
	 */
	private $validator;

	/**
	 * CliHelper constructor.
	 * @param IValidator $validator
	 * @param $count
	 */
	public function __construct(IValidator $validator,$count)
	{
		$this->validateNumberOfArgs($count);
		$this->validator = $validator;
	}

	/**
	 * Checks number of arguments passed to CLI
	 *
	 * @param integer $count
	 * @throws Exception
	 */
	private function validateNumberOfArgs($count)
	{
		if ($count !== 4) {
			throw new Exception("Not enough arguments.");
		}
	}

	/**
	 * Parses the argument passed to CLI and returns the vendorID
	 *
	 * @param string $arg
	 * @return mixed
	 */
	public function getIntArg($arg)
	{
		return $this->validator->validateInt($arg);
	}

	/**
	 * Validate the date passed to CLI and returns it
	 *
	 * @param string $arg
	 * @param string $format
	 * @param string $timezone
	 * @return mixed
	 */
	public function getDateArg($arg, $format, $timezone)
	{
		return $this->validator->validateDate($arg, $format, $timezone);
	}
} 