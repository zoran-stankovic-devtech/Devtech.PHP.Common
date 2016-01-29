<?php
/**
 * Created by PhpStorm.
 * User: zoran.stankovic
 * Date: 1/29/2016
 * Time: 1:20 PM
 */

namespace Devtech\Common;


class Validator implements IValidator
{
	/**
	 * @param string $argument
	 * @return int
	 * @throws Exception
	 */
	public function validateInt($argument)
	{
		$arg = (int)$argument;
		if (is_numeric($arg) && $arg > 0) {
			return $arg;
		} else {
			throw new Exception("Please enter the number for the vendor id as acript's first argument.");
		}
	}

	/**
	 * @param string $argument
	 * @param string $format
	 * @param string $timezone
	 * @return string
	 * @throws Exception
	 */
	public function validateDate($argument, $format, $timezone)
	{
		$date = $this->isValidDateTimeString($argument, $format, $timezone);
		if ($date === true) {
			return $argument;
		} else {
			throw new Exception('The value ' . $argument . ' is not valid date. Please enter valid date.');
		}
	}

	/**
	 * @param string $strDate
	 * @param string $strDateFormat
	 * @param string $strTimezone
	 * @return bool
	 */
	private function isValidDateTimeString($strDate, $strDateFormat, $strTimezone)
	{
		$date = DateTime::createFromFormat($strDateFormat, $strDate, new DateTimeZone($strTimezone));
		return $date && DateTime::getLastErrors()['warning_count'] === 0 && DateTime::getLastErrors()['error_count'] === 0;
	}
}