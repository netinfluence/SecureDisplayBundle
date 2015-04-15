<?php

namespace Netinfluence\SecureDisplayBundle\Twig;

use Netinfluence\SecureDisplayBundle\Services\Encrypter;

class SecureDisplayExtension extends \Twig_Extension
{
	private $translator;
	private $encrypter;
	private $id;

	public function __construct($translator, Encrypter $encrypter)
	{
		$this->translator = $translator;
		$this->encrypter = $encrypter;
		$this->id = 1;
	}
	
	public function getFilters()
	{
		return array(
			new \Twig_SimpleFilter('secureDisplay', array($this, 'hashFilter'), array(
                'is_safe' => array('html'),
                'needs_environment' => true
            )),
		);
	}

	public function hashFilter(\Twig_Environment $twig, $number, $label = null, $action = null, array $attr = [])
	{
		// Encrypt the value
		$hash = $this->encrypter->encrypt($number);

		// Translate the given label or use default one
		if($label) {
			$label = $this->translator->trans($label);
		}else{
			$label = "This value is protected";
		}

        return $twig->render('NetinfluenceSecureDisplayBundle::secure_display.html.twig', array(
            'action' => $action,
            'attr'  => $attr,
            'hash'  => $hash,
            'id'    => $this->id++,
            'label' => $label
        ));
	}

	public function getName()
	{
		return 'secure_display_extension';
	}
}

