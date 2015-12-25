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
	 * Parses the arguments passed to CLI and returns the vendorID
	 *
	 * @param array $args
	 * @return int
	 * @throws \Exception
	 */

	public static function getVendorId($args) {
		if (count($args) > 1 && is_numeric($args[1]) && $args[1] > 0) {
			return $args[1];
		} else {
			throw new \Exception("Argument missing, please provide vendor id as script's first argument.");
		}
	}

	/**
	 * @param $args
	 * @return mixed
	 * @throws \Exception
	 */
	public static function getReportPeriod($args){
		if (count($args) > 1 && is_string($args[2])){
			return $args[2];
		}else{
			throw new \Exception("Argument missing, please provide date period as script's second argument.");
		}
	}
} 