<?php
/**
 * Created by PhpStorm.
 * User: nemanja.tomic
 * Date: 20.1.2016
 * Time: 15:04
 */

namespace Devtech\Collection;


class CollectionException extends \Exception {
	public function __construct($message, \Exception $inner = null) {
		parent::__construct($message, 0, $inner);
	}
}