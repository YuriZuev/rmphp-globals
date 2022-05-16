<?php
/**
 * Created by PhpStorm.
 * User: Zuev Yuri
 * Date: 03.10.2021
 * Time: 4:25
 */

namespace Rmphp\Globals;



class Session {

	public function __construct(string $name = "usi") {
		session_name($name);
		session_start();
	}

	/**
	 * @return array
	 */
	public function getSession() : array {
		return $_SESSION;
	}
}