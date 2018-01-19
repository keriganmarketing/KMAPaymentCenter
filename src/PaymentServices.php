<?php
/**
 * Created by PhpStorm.
 * User: Bryan
 * Date: 1/18/2018
 * Time: 4:19 PM
 */

namespace KMAPaymentCenter;


class PaymentServices
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
    }


}