<?php
/**
 * Created by PhpStorm.
 * User: bbair
 * Date: 1/22/2018
 * Time: 11:22 AM
 */

namespace KMAPaymentCenter;


class FormShortcode
{
	public $pluginDir;
	public $pluginSlug;
	public $pluginName;
	protected $processorConfig;

	public function __construct()
	{
		$config = new PluginConfig();
		$this->pluginDir = $config->getVar('pluginDir');
		$this->pluginSlug = $config->getVar('pluginSlug');
		$this->pluginName = $config->getVar('pluginName');
		$this->pluginName = $config->getVar('processorConfig');

		$this->addShortcode();
	}

	protected function showForm()
	{
		$imageDir = plugin_dir_url(dirname(__FILE__)) . '/forms/images';
		include($this->pluginDir . '/forms/payment-form-standard.php');
	}

	protected function addShortcode()
	{
		add_shortcode( 'payment_form', function( $atts ){
			$this->showForm();
		} );
	}
}