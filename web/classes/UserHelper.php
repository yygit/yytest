<?php
/**
 * Project: yytest
 * File: UserHelper.php
 * User: YY
 * Date: 18.04.2021
 */

class UserHelper
{
	/**
	 * @var string
	 */
	private $referrerPage;

	/**
	 * Figure out user referrer page and define its suffix.
	 *
	 * @throws Exception
	 */
	public function __construct()
	{
		if (!isset($_SERVER['HTTP_REFERER'])) {
			throw new Exception('Cannot figure out user referrer page!');
		}

		$this->referrerPage = $_SERVER['HTTP_REFERER'];
		// $this->referrerPage = 'index1.html';
	}

	/**
	 * @return string eg index1.html, index2.html
	 */
	public function getReferrerPage(): string
	{
		return $this->referrerPage;
	}

	/**
	 * Get banner suffix from ref page eg index1.html -> '1'
	 *
	 * @return string eg '1'
	 * @throws Exception
	 */
	public function getBannerSuffix(): string
	{
		$pathParts = pathinfo($this->referrerPage);

		if (!isset($pathParts['filename'])) {
			throw new Exception('Cannot figure out referrer page file name!');
		}

		if (!preg_match('"[\d]+$"', $pathParts['filename'], $m)) {
			throw new Exception('Cannot figure out banner suffix from file name!');
		}

		return $m[0];
	}

	/**
	 * @return string
	 */
	public static function getIPAddress(): string
	{
		if (!empty($_SERVER['HTTP_CLIENT_IP'])) { //whether ip is from the share internet
			$ip = $_SERVER['HTTP_CLIENT_IP'];
		}
		elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) { //whether ip is from the proxy
			$ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
		}
		else { //whether ip is from the remote address
			$ip = $_SERVER['REMOTE_ADDR'];
		}

		return $ip;
	}

	/**
	 * @return string
	 */
	public static function getUserAgent(): string
	{
		return $_SERVER['HTTP_USER_AGENT'] ?: 'unknown_user_agent';
	}
}