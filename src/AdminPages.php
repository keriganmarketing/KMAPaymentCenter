<?php

namespace KMAPaymentCenter;
use KMAPaymentCenter\PluginConfig;

class AdminPages
{
    public function __construct()
    {
        $this->addMenus();
    }

    public function addMenus()
    {
        add_menu_page("Payment Terminal", "Payment Terminal", "administrator", 'anpt-terminal-slug', function () {
            echo '<h1>It works!</h1>';
        }, "dashicons-cart");
    }
}