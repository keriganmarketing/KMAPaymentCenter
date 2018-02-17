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
    public $state;

    public function __construct()
    {
        $config = new PluginConfig();
        $this->pluginDir = $config->getVar('pluginDir');
        $this->pluginSlug = $config->getVar('pluginSlug');
        $this->pluginName = $config->getVar('pluginName');
        $this->pluginName = $config->getVar('processorConfig');
    }

    public function handleSubmit($post){
        if($this->state == 'change'){
            return $this->editService($post);
        }elseif($this->state == 'add'){
            return $this->addService($_POST);
        }
    }

    public function handleState($get)
    {
        if(isset($get['change']) && $get['change'] == 1){
            $this->state = 'change';
        }elseif(isset($get['delete']) && $get['delete'] == 1){
            $this->state = 'delete';
            return $this->deleteService($get['id']);
        }else{
            $this->state = 'add';
        }
        return $this->state;
    }

    public function getEditFromState($get)
    {
        global $wpdb;

        if(!isset($get['id'])){
            return false;
        }

        $output = $wpdb->get_row(
            "
            SELECT *
            FROM " . $wpdb->prefix . "kmapc_services
            WHERE kmapc_services_id = " . $get['id'] . "
            ",
            'OBJECT'
        );

        return $output;
    }

    protected function editService($data)
    {

        global $wpdb;

        $wpdb->replace(
            $wpdb->prefix."kmapc_services",
            [
                'kmapc_services_title' => addslashes(strip_tags($data['kmapc_services_title'])),
                'kmapc_services_descr' => addslashes(strip_tags($data['kmapc_services_descr'])),
                'kmapc_services_recurring' => addslashes(strip_tags($data['kmapc_services_recurring'])),
                'kmapc_services_recurring_period_type' => addslashes(strip_tags($data['kmapc_services_recurring_period_type'])),
                'kmapc_services_recurring_period_number' => addslashes(strip_tags($data['kmapc_services_recurring_period_number'])),
                'kmapc_services_price' => addslashes(strip_tags($data['kmapc_services_price']))
            ]
        );

        return 'changing service ' . $data->kmapc_services_id;
    }

    protected function deleteService($id)
    {
        return 'deleting service ' . $id;
    }

    protected function addService($data)
    {
        global $wpdb;

        //Form data sent
        $pt_title = $data['kmapc_services_title'];
        $pt_descr = $data['kmapc_services_descr'];
        $pt_price = $data['kmapc_services_price'];

        if(is_numeric($pt_price) && !empty($pt_title)) {

            $wpdb->insert(
                $wpdb->prefix."kmapc_services",
                [
                    'kmapc_services_title' => addslashes(strip_tags($pt_title)),
                    'kmapc_services_descr' => addslashes(strip_tags($pt_descr)),
                    'kmapc_services_recurring' => addslashes(strip_tags($data['kmapc_services_recurring'])),
                    'kmapc_services_recurring_period_type' => addslashes(strip_tags($data['kmapc_services_recurring_period_type'])),
                    'kmapc_services_recurring_period_number' => addslashes(strip_tags($data['kmapc_services_recurring_period_number'])),
                    'kmapc_services_price' => addslashes(strip_tags($pt_price))
                ]
                );

            return 'Service added.';
        } else {
            return'Service not added! Please check your input. Price must contain numbers only and name cannot be blank.';
        }
    }

    public function getServices()
    {
        global $wpdb;

        $output = $wpdb->get_results(
            "
            SELECT *
            FROM " . $wpdb->prefix . "kmapc_services
            "
        );

        return $output;
    }


}