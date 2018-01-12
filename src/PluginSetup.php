<?php

namespace KMAPaymentCenter;

use KMAPaymentCenter\PluginConfig;

class PluginSetup
{
    protected $processorConfig;

    public function __construct()
    {
        $this->processorConfig = [
            'Authorize'=>[
                'LIVE'=>[
                    'API Login ID'=>'your_LIVE_login_id',
                    'API Transaction Key'=>'your_LIVE_transaction_key'
                ],
                'TEST'=>[
                    'API Login ID'=>'your_SANDBOX_login_id',
                    'API Transaction Key'=>'your_SANDBOX_transaction_key'
                ]
            ]
        ];
    }

    public function installPlugin()
    {
        global $wpdb;

        //let's create transaction table.
        $table = $wpdb->prefix."kmapc_transactions";

        $structure = "CREATE TABLE IF NOT EXISTS $table (
					kmapc_id int(20) NOT NULL auto_increment,
					kmapc_dateCreated datetime default '0000-00-00 00:00:00',
					kmapc_amount double NOT NULL,
					kmapc_payer_email varchar(255) default NULL,
					kmapc_comment longtext,
					kmapc_transaction_id varchar(255) default NULL,
					kmapc_status tinyint(5) default '1',
					kmapc_payer_name varchar(255) NOT NULL,
					kmapc_serviceID int(20) NOT NULL default '0',
					kmapc_service_name  varchar(255) NOT NULL,
					kmapc_bill_cycle  varchar(255) NOT NULL,
					kmapc_recurring tinyint(5) default '0',
					kmapc_recurring_cancelled tinyint(5) default '0',
					UNIQUE KEY kmapc_id (anpt_id),
					UNIQUE KEY kmapc_transaction_id (kmapc_transaction_id))
					ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;";

        $wpdb->query($structure);

        //now create services table
        $table = $wpdb->prefix."kmapc_services";
        $structure = "CREATE TABLE IF NOT EXISTS $table (
					kmapc_services_id INT(20) NOT NULL AUTO_INCREMENT,
					kmapc_services_title VARCHAR(255) NOT NULL,
					kmapc_services_price DOUBLE NOT NULL,
					kmapc_services_recurring BOOLEAN default 0,
					kmapc_services_recurring_period_type varchar(10),
					kmapc_services_recurring_period_number INT(20) not null default 0,
					kmapc_services_recurring_trial BOOLEAN default 0,
					kmapc_services_recurring_trial_days INT(20) not null default 0,
					kmapc_services_descr MEDIUMTEXT NULL,
					UNIQUE KEY kmapc_services_id (anpt_services_id));";
        $wpdb->query($structure);

        update_option('kmapc_processor',"1");
        update_option('kmapc_currency',"USD");
        update_option('kmapc_ty_title',"Thank You!");
        update_option('kmapc_ty_text',"<p>Your payment has been completed. Thank you.</p>");
        update_option('kmapc_intro_text',"<p>Our online payment form is included below.</p>");
        update_option('kmapc_admin_email',"support@kerigan.com");
        update_option('kmapc_admin_send',"1");
        update_option('kmapc_show_comment_field',"1");
        update_option('kmapc_show_dd_text',"2"); //show drop down with services 1 or show text box for input 2
        update_option('kmapc_test',"1");
    }

    public function uninstallPlugin()
    {
        $config = new PluginConfig();
        $config->setTerminalState($this->processorConfig,'uninstall');

        delete_option('kmapc_processor');
        delete_option('kmapc_currency');
        delete_option('kmapc_ty_title');
        delete_option('kmapc_ty_text');
        delete_option('kmapc_intro_text');
        delete_option('kmapc_admin_email');
        delete_option('kmapc_admin_send');
        delete_option('kmapc_show_comment_field');
        delete_option('kmapc_show_dd_text');
        delete_option('kmapc_license');
        delete_option('kmapc_test');
    }

    public function updatePlugin()
    {

    }
}