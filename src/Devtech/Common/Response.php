<?php
/**
 * Created by PhpStorm.
 * User: dejan.obradovic
 * Date: 6/30/14
 * Time: 4:23 PM
 */
namespace Devtech\Common;

class Response {
	public $success;
	public $message;
	public $data;

	public function __construct() {
		$this->success = true;
	}
} 