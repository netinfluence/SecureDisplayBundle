<?php

namespace Netinfluence\SecureDisplayBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

class DisplayController extends Controller
{
	public function decryptAction(Request $request)
	{
		$encrypter = $this->get('encrypter');

		$data = $request->request->get('keys', array());
		$results = array();
		
		foreach ($data as $key => $value) {
			$results[$key] = $encrypter->decrypt($value);
		}
		return new Response(json_encode($results));
	}
}
