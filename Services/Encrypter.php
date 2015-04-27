<?php

namespace Netinfluence\SecureDisplayBundle\Services;

use Symfony\Component\HttpFoundation\Session\Session;
class Encrypter
{
	const SESSION_IV_KEY = 'encrypter-iv';
	private $session;
	private $method;
	private $key;
	private $iv;

	public function __construct(Session $session, $key)
	{
		$iv = $session->get(self::SESSION_IV_KEY, null);

		if($iv !== null) {
			$this->iv = $iv;
		}else{
			$this->iv = openssl_random_pseudo_bytes(16);
			$session->set(self::SESSION_IV_KEY, $this->iv);
		}

		$this->method = "AES-256-CBC";
		$this->key = hash('sha256', $key);
	}

	public function encrypt($string) {
		$output = openssl_encrypt($string, $this->method, $this->key, 0, $this->iv);
		return base64_encode($output);
	}

	public function decrypt($string) {
		return openssl_decrypt(base64_decode($string), $this->method, $this->key, 0, $this->iv);
	}
}
