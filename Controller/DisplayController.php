<?php

namespace Netinfluence\SecureDisplayBundle\Controller;

use Netinfluence\SecureDisplayBundle\Services\Encrypter;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class DisplayController extends Controller
{
	/**
	 * @param Request $request
	 * @return \Symfony\Component\HttpFoundation\Response
	 */
	public function decryptAction(Request $request)
	{
		// Get encryption service
		$encrypter = $this->get(Encrypter::class);

		// Get data to decrypt
		$data = $request->request->get('keys', []);

		// Prepare results
		$results = array();

		// Loop on each key and decrypt it
		foreach ($data as $key => $value) {
			$results[$key] = $encrypter->decrypt($value);
		}

		// Return json formated array of results
		return new JsonResponse($results);
	}
}
