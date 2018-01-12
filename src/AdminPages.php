<?php

namespace KMAPaymentCenter;
use KMAPaymentCenter\PluginConfig;

class AdminPages
{
    public function __construct()
    {
        add_action('admin_menu', function(){
            $this->addMenus();
        });

        add_action('admin_enqueue_scripts', function() {
            $this->loadCss();
        });

    }

    protected function loadCss()
    {
        wp_enqueue_style('bluma_admin_css', 'https://cdnjs.cloudflare.com/ajax/libs/bulma/0.6.2/css/bulma.min.css',false, '1.0.0');
    }

    public function addMenus()
    {
        add_menu_page("Payment Center", "Payment Center", "administrator", 'kma-payments', function () {
            include(wp_normalize_path(PluginDir . '/templates/AdminOverview.php'));
        }, "dashicons-feedback");

        add_submenu_page( 'kma-payments', 'Payment Center Settings', 'Settings', 'administrator', 'payment-settings', function() {
            include(wp_normalize_path(PluginDir . '/templates/AdminSettings.php'));
        });

        add_submenu_page( 'kma-payments', 'Payment Center Transactions', 'Transactions', 'administrator', 'payment-transactions', function() {
            include(wp_normalize_path(PluginDir . '/templates/AdminTransactions.php'));
        });
    }
}