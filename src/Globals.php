<?php
/**
 * Created by PhpStorm.
 * User: Zuev Yuri
 * Date: 24.08.2021
 * Time: 18:55
 */

namespace Rmphp\Globals;

use Psr\Http\Message\ServerRequestInterface;

class Globals {

	private ServerRequestInterface $request;
	private Session $session;

	const INT = "INT";
	const STRING = "STRING";

	/**
	 * Globals constructor.
	 * @param ServerRequestInterface $request
	 */
	public function __construct(ServerRequestInterface $request) {
		if(class_exists(Session::class)) $this->session = new Session();
		$this->request = $request;
		define("INT", "INT");
		define("SRTING", "STRING");
	}

	public function session() : Session {
		return $this->session;
	}

	/**
	 * @return ServerRequestInterface
	 */
	public function request() : ServerRequestInterface {
		return $this->request;
	}

	/**
	 * @param string $name
	 * @return bool
	 */
	public function isGet(string $name = "") : bool {
		return (!empty($name)) ? isset($this->request->getQueryParams()[$name]) : !empty($this->request->getQueryParams());
	}

	/**
	 * @param string $name
	 * @return bool
	 */
	public function isPost(string $name = "") : bool {
		return (!empty($name)) ? isset($this->request->getParsedBody()[$name]) : !empty($this->request->getParsedBody());
	}

	/**
	 * @param string $name
	 * @return bool
	 */
	public function isCookie(string $name = "") : bool {
		return (!empty($name)) ? isset($this->request->getCookieParams()[$name]) : !empty($this->request->getCookieParams());
	}

	/**
	 * @param string $name
	 * @return bool
	 */
	public function isFile(string $name = "") : bool {
		return (!empty($name)) ? isset($this->request->getUploadedFiles()[$name]) : !empty($this->request->getUploadedFiles());
	}

	/**
	 * @return bool
	 */
	public function isStream() : bool {
		return !empty($this->request->getBody()->getContents());
	}

	/**
	 * @param string $name
	 * @param string $type
	 * @return array|int|string
	 */
	public function get(string $name = "", string $type = "") {
		return $this->onGlobal($this->request->getQueryParams(), $name, $type);
	}

	/**
	 * @param string $name
	 * @param string $type
	 * @return array|int|string
	 */
	public function post(string $name = "", string $type = "") {
		return $this->onGlobal($this->request->getParsedBody(), $name, $type);
	}

	/**
	 * @param string $name
	 * @param string $type
	 * @return array|int|string
	 */
	public function cookie(string $name = "", string $type = "") {
		return $this->onGlobal($this->request->getCookieParams(), $name, $type);
	}

	/**
	 * @param string $name
	 * @return array|int|string
	 */
	public function files(string $name = "") {
		return $this->onGlobal($this->request->getUploadedFiles(), $name);
	}

	/**
	 * @return string|null
	 */
	public function stream(){
		return !empty($this->request->getBody()->getContents()) ? $this->request->getBody()->getContents(): null;
	}

	/**
	 * @param array $var
	 * @param string $name
	 * @param string $type
	 * @return array|int|string
	 */
	private function onGlobal(array $var, string $name, string $type = "") {
		if (!empty($name))
		{
			if (!isset($var[$name])) return [];

			if (empty($type)) {
				return $var[$name];
			}
			elseif ($type == self::STRING) {
				return (!empty($var[$name])) ? (string)$var[$name] : [];
			}
			elseif ($type == self::INT) {
				return (!empty((int)$var[$name]) || $var[$name]==0) ? (int)$var[$name] : [];
			}
		}
		return (isset($var)) ? $var : [];
	}
}