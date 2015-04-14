<?php

namespace Netinfluence\SecureDisplayBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

class DisplayController extends Controller
{
	public function decryptAction(Request $request)
	{
		$id = $request->request->get('id');
		$hash = $request->request->get('hash');
		$encrypter = $this->get('encrypter');
		$value = $encrypter->decrypt($hash);
		$result = array('key' => $id, 'value' => $value);
		return new Response(json_encode($result));
	}
}
