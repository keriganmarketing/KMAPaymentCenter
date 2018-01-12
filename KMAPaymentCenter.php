<?php
/*
 * Plugin Name: KMA Payment Center for Authorize.net
 * Plugin URI: https://www.keriganmarketing.com
 * Description: Plugin allows easy payments or donations by credit cards on your blog, on any page or post
 * Author: Kerigan Marketing Associates
 * Version: 1.7
 * Release Date: 1/12/18
 * Latest Update: 1/12/18
 * Initial Release Date: 1/12/18
 * Author URI: https://www.keriganmarketing.com
 *
 * @package KMAPaymentCenter
 * @since 1.3
 * @version 1.7
 */

require_once ('vendor\autoload.php');
define('PluginDir', dirname(__FILE__));

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
        new KMAPaymentCenter\PluginUpdater( [
            'slug' => plugin_basename(__FILE__),
            'proper_folder_name' => 'KMAPaymentCenter',
            'api_url' => 'https://api.github.com/keriganmarketing/KMAPaymentCenter',
            'raw_url' => 'https://raw.github.com/keriganmarketing/KMAPaymentCenter/master',
            'github_url' => 'https://github.com/keriganmarketing/KMAPaymentCenter',
            'zip_url' => 'https://github.com/keriganmarketing/KMAPaymentCenter/archive/master.zip',
            'sslverify' => true,
            'requires' => '3.0',
            'tested' => '3.3',
            'readme' => 'README.md',
            'access_token' => '',
        ] );
        new KMAPaymentCenter\AdminPages();
    }
});
