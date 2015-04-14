<?php

namespace Netinfluence\SecureDisplayBundle\Services;

class Encrypter
{
	private $method;
	private $key;
	private $iv;

	public function __construct($key)
	{
		// Change IV each minute
		$time = round(time()/60)*60;
		$this->iv = substr(hash('sha256', $time), 0, 16);

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
