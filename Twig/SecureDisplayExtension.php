<?php

namespace Netinfluence\SecureDisplayBundle\Twig;

use Netinfluence\SecureDisplayBundle\Services\Encrypter;

class SecureDisplayExtension extends \Twig_Extension
{
    /**
     * @var Encrypter
     */
	private $encrypter;

    /**
     * @var int
     */
	private $id;

    /**
     * @var string
     */
    private $template;

	public function __construct(Encrypter $encrypter, $template)
	{
		$this->encrypter = $encrypter;
		$this->id = 1;
        $this->template = $template;
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

	public function hashFilter(\Twig_Environment $twig, $number, $label = 'secure_display.fail_label', $action = null, array $attr = array())
	{
		// Encrypt the value
		$hash = $this->encrypter->encrypt($number);

        return $twig->render($this->template, array(
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
