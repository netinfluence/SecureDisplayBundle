<?php

namespace Netinfluence\SecureDisplayBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class DisplayController extends Controller
{
	public function decryptAction($id, $hash)
	{
		$encrypter = $this->get('encrypter');
		$value = $encrypter->decrypt($hash);
		$result = array('key' => $id, 'value' => $value);
		return new Response(json_encode($result));
	}
}
