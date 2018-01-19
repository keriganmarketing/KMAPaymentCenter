<?php
/*
 * Plugin Name: KMA Payment Center for Authorize.net
 * Plugin URI: https://www.keriganmarketing.com
 * Description: Plugin allows easy payments or donations by credit cards on your blog, on any page or post
 * Author: Kerigan Marketing Associates
 * Version: 1.7.2
 * Release Date: 1/12/18
 * Latest Update: 1/12/18
 * Initial Release Date: 1/12/18
 * Author URI: https://www.keriganmarketing.com
 *
 * @package KMAPaymentCenter
 * @since 1.3
 * @version 1.7.2
 */

require_once ('vendor\autoload.php');

//add the hooks for install/uninstall and menu.
register_activation_hook( __FILE__, function(){
    $install = new KMAPaymentCenter\PluginSetup();
    $install->installPlugin();
});

register_deactivation_hook(__FILE__, function(){
    $uninstall = new KMAPaymentCenter\PluginSetup();
    $uninstall->uninstallPlugin();
});

//updater
add_action('init', function(){
    if(!is_admin()) {
        return;
    }else{

        $update = new KMAPaymentCenter\PluginSetup();
        $update->updatePlugin();

        new KMAPaymentCenter\AdminPages();
    }
});
