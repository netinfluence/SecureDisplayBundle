<?php

namespace Netinfluence\SecureDisplayBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * This is the class that validates and merges configuration from your app/config files
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html#cookbook-bundles-extension-config-class}
 */
class Configuration implements ConfigurationInterface
{
	/**
	 * {@inheritdoc}
	 */
	public function getConfigTreeBuilder()
	{
		$treeBuilder = new TreeBuilder();
		$rootNode = $treeBuilder->root('netinfluence_secure_display');

		$rootNode
			->children()
				->scalarNode('key')->end()
                ->scalarNode('template')
                    ->defaultValue('NetinfluenceSecureDisplayBundle::secure_display.html.twig')
                ->end()
			->end()
		->end();

		return $treeBuilder;
	}
}
