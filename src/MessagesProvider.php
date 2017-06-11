<?php

namespace Hiraeth\Messages;

use Hiraeth;
use Plasticbrain\FlashMessages;

class MessagesProvider implements Hiraeth\Provider
{
	/**
	 *
	 */
	protected $classmap = [
		'ERROR'   => 'messaging error',
		'WARNING' => 'messaging warning',
		'SUCCESS' => 'messaging success',
		'INFO'    => 'messaging info',
	];


	/**
	 *
	 */
	protected $config = NULL;


	/**
	 * Get the interfaces for which the provider operates.
	 *
	 * @access public
	 * @return array A list of interfaces for which the provider operates
	 */
	static public function getInterfaces()
	{
		return [
			'Plasticbrain\FlashMessages\FlashMesssages'
		];
	}


	/**
	 *
	 */
	public function __construct(Hiraeth\Configuration $config)
	{
		$this->config = $config;
	}


	/**
	 * Prepare the instance.
	 *
	 * @access public
	 * @return Object The prepared instance
	 */
	public function __invoke($instance, Hiraeth\Broker $broker)
	{
		$classmap = array();

		foreach ($this->config->get('pb-messages', 'classmap', $this->classmap) as $type => $classes) {
			$classmap[$instance::$type] = $classes;
		}

		$this->setCssClassMap($classmap);

		return $instance;
	}
}
