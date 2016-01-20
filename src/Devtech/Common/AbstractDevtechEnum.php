<?php
/**
 * Created by PhpStorm.
 * User: nemanja.tomic
 * Date: 28.9.2015
 * Time: 16:19
 */

namespace Devtech\Common;

/**
 * Class AbstractDevtechEnum is used as a base class for enums.
 * AbstractDevtechEnum provides basic enum functionality such as enum name and value validation.
 *
 * Reference: http://stackoverflow.com/questions/254514/php-and-enumerations
 *
 * @package Enums
 */
abstract class AbstractDevtechEnum {
	private static $constCacheArray;

	public static function isValidName($name, $strict = false) {
		$constants = self::getConstants();

		if ($strict) {
			return array_key_exists($name, $constants);
		}

		$keys = array_map('strtolower', array_keys($constants));
		return in_array(strtolower($name), $keys, null);
	}

	public static function isValidValue($value) {
		$values = array_values(self::getConstants());
		return in_array($value, $values, $strict = true);
	}

	private static function getConstants() {
		if (self::$constCacheArray === null) {
			self::$constCacheArray = array();
		}
		$calledClass = get_called_class();
		if (!array_key_exists($calledClass, self::$constCacheArray)) {
			$reflect = new \ReflectionClass($calledClass);
			self::$constCacheArray[$calledClass] = $reflect->getConstants();
		}
		return self::$constCacheArray[$calledClass];
	}
}