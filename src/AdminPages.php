<?php

namespace KMAPaymentCenter;
use KMAPaymentCenter\PluginConfig;

class AdminPages
{
    public function __construct()
    {
        $this->addMenus();
        $this->loadCss();
    }

    protected function loadCss()
    {
        add_action('admin_enqueue_scripts', function(){
            wp_enqueue_style('bluma_admin_css', 'https://cdnjs.cloudflare.com/ajax/libs/bulma/0.6.2/css/bulma.min.css',false, '1.0.0');
        });
    }

    public function addMenus()
    {
        add_menu_page("Payment Center", "Payment Center", "administrator", 'kmapayments', function () {
            include(wp_normalize_path(PluginDir . '/templates/AdminOverview.php'));
        }, "dashicons-feedback",55);

        add_submenu_page( 'kmapayments', 'Payment Center Settings', 'Settings', 'administrator', 'settings', function() {
            include(wp_normalize_path(PluginDir . '/templates/AdminSettings.php'));
        });
    }
}