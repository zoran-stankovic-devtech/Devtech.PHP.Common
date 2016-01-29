<?php
/**
 * Created by PhpStorm.
 * User: zoran.stankovic
 * Date: 1/29/2016
 * Time: 1:08 PM
 */

namespace Devtech\Common;


interface IValidator
{
	/**
	 * @param string $argument
	 * @return mixed
	 */
	public function validateInt($argument);

	/**
	 * @param string $argument
	 * @param string $format
	 * @param string $timezone
	 * @return mixed
	 */
	public function validateDate($argument, $format, $timezone);
}