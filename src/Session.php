<?php
/**
 * Created by PhpStorm.
 * User: Zuev Yuri
 * Date: 03.10.2021
 * Time: 4:25
 */

namespace Rmphp\Globals;


class Session {

	const INT = "INT";
	const STRING = "STRING";

	public function __construct(string $name = "usi") {
		session_name($name);
		session_start();
	}

	/**
	 * @param string $name
	 * @return bool
	 */
	public function isSession(string $name = "") : bool {
		return (!empty($name)) ? isset($_SESSION) && isset($_SESSION[$name]) : isset($_SESSION);
	}

	/**
	 * @param string $name
	 * @param $value
	 */
	public function setSession(string $name, $value) : void {
		$_SESSION[$name] = $value;
	}

	/**
	 * @param string $name
	 * @param string $type
	 * @return array|int|mixed|string
	 */
	private function getSession(string $name, string $type = "") {
		if (!empty($name))
		{
			if (!isset($_SESSION[$name])) return [];

			if (empty($type)) {
				return $_SESSION[$name];
			}
			elseif ($type == self::STRING) {
				return (!empty($_SESSION[$name])) ? (string)$_SESSION[$name] : [];
			}
			elseif ($type == self::INT) {
				return (!empty((int)$_SESSION[$name]) || $_SESSION[$name]==0) ? (int)$_SESSION[$name] : [];
			}
		}
		return (isset($_SESSION)) ? $_SESSION : [];
	}
}