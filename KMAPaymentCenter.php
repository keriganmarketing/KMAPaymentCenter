<?php
/*
Plugin Name: KMA Payment Center for Authorize.net
Plugin URI: https://www.keriganmarketing.com
Description: Plugin allows easy payments or donations by credit cards on your blog, on any page or post
Author: Kerigan Marketing Associates
Version: 1.0
Release Date: 1/12/18
Latest Update: 1/12/18
Initial Release Date: 1/12/18
Author URI: https://www.keriganmarketing.com
*/

/**
 * Note: the version # above is purposely low in order to be able to test the updater
 * The real version # is below
 *
 * @package GithubUpdater
 * @author Joachim Kudish @link http://jkudish.com
 * @since 1.3
 * @version 1.5
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
