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
			new \Twig_SimpleFilter('secureDisplay', array($this, 'hashFilter'), array('is_safe' => array('html'))),
		);
	}

	public function hashFilter($number, $label = null, array $attr = null)
	{
		// Encrypt the value
		$hash = $this->encrypter->encrypt($number);

		// Translate the given label or use default one
		if($label) {
			$label = $this->translator->trans($label);
		}else{
			$label = "This value is protected";
		}

		// Generate the span with the given optional attributes
		$link = "<span data-type='secure-display' data-value='" . $hash . "' data-id='" . $this->id++ . "'";
		if($attr !== null && is_array($attr) && !empty($attr)) {
			foreach ($attr as $key => $value) {
				$link .= " " . $key . "='" . htmlspecialchars($value, ENT_QUOTES, 'UTF-8', false) . "'";
			}
		}
		$link .= ">" . $label . "</span>";
		return $link;
	}

	public function getName()
	{
		return 'secure_display_extension';
	}
}

