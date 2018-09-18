<?php

namespace Hiraeth\Messages;

use Hiraeth;

/**
 *
 */
class MessagesProvider implements Hiraeth\Provider
{
	/**
	 *
	 */
	protected $classmap = [
		'ERROR'   => 'error',
		'WARNING' => 'warning',
		'SUCCESS' => 'success',
		'INFO'    => 'info',
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
			'Plasticbrain\FlashMessages\FlashMessages'
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
			$classmap[constant(get_class($instance) . '::' . $type)] = $classes;
		}

		$instance->setMsgCssClass($this->config->get('pb-messages', 'class', 'messaging'));
		$instance->setCssClassMap($classmap);
		$instance->setMsgBefore('<p>');
		$instance->setMsgAfter('</p>');

		return $instance;
	}
}
