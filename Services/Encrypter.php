<?php

namespace Netinfluence\SecureDisplayBundle\Services;

use Symfony\Component\HttpFoundation\Session\Session;
class Encrypter
{
	/**
	 * 
	 * @var string
	 */
	const SESSION_IV_KEY = 'encrypter-iv';

	/**
	 * 
	 * @var string
	 */
	private $method;

	/**
	 * 
	 * @var string
	 */
	private $key;

	/**
	 * 
	 * @var string
	 */
	private $iv;

	public function __construct(Session $session, $key)
	{
		// Get or create the IV
		$iv = $session->get(self::SESSION_IV_KEY, null);

		if($iv !== null) {
			$this->iv = $iv;
		}else{
			$this->iv = openssl_random_pseudo_bytes(16);
			$session->set(self::SESSION_IV_KEY, $this->iv);
		}

		// Define encryption method and encryption key
		$this->method = "AES-256-CBC";
		$this->key = hash('sha256', $key);
	}

	/**
	 * Encrypt the given string
	 * 
	 * @param string $string
	 * @return string
	 */
	public function encrypt($string) {
		$output = openssl_encrypt($string, $this->method, $this->key, 0, $this->iv);
		return base64_encode($output);
	}

	/**
	 * Decrypt the given string
	 * 
	 * @param string $string
	 * @return string
	 */
	public function decrypt($string) {
		return openssl_decrypt(base64_decode($string), $this->method, $this->key, 0, $this->iv);
	}
}
