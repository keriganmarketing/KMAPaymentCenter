<?php

namespace KMAPaymentCenter;


class PluginConfig
{
    public function __construct()
    {
    }

    public function setTerminalState($paymentTerminals, $action )
    {
        $output = [];
        $testMode = get_option('kmapc_test');

        foreach($paymentTerminals as $terminal => $details){
            $terminal = strtoupper(str_replace([
                ',',
                ' ',
                '.',
                '\''
            ], '_', $terminal));

            $wpdbVars = (is_string(get_option('kmapc_details_'.$terminal))) ?
                unserialize(get_option('kmapc_details_'.$terminal)) :
                get_option('kmapc_details_'.$terminal);

            $postVars = [];
            foreach($details as $case => $fields){
                if($case=='TEST'||$case == 'LIVE'){
                    $caseArray = [];
                    foreach($fields as $field => $value){
                        $postName = strtoupper(str_replace(array(',',' ','.','\''), '_', $field));
                        $inputId = strtolower(str_replace(array(' ','"','\'','.'), '_', $terminal."_".$case."_".$field));
                        if(isset($_POST['kmapc_submit_settings']) && $_POST['kmapc_submit_settings'] == 'yes' && isset($_POST["{$inputId}"])){
                            $postValue = stripslashes_deep($_POST["{$inputId}"]);
                        } else if($action == "install" || $action == "uninstall") {
                            $postValue = $value;
                        } else {
                            $postValue = $wpdbVars[strtolower($case)][$postName];
                        }

                        $caseArray[$postName] = $postValue;
                        $output[$terminal][$case][$field] = $postValue;
                    }
                }
                $case = strtolower($case);
                $postVars[$case] = $caseArray;
            }

            if($action == "install" || (isset($_POST['kmapc_submit_settings']) && $_POST['kmapc_submit_settings'] == 'yes')){
                $postVars = serialize($postVars);
                update_option('kmapc_details_'.$terminal,$postVars);
            }elseif($action == "uninstall"){
                delete_option('kmapc_details_'.$terminal);
            }
        }
        unset($postVars);
        unset($caseArray);
        return $output;
    }

    protected function displaySelectedCondition($i,$processor)
    {
        $condition = (($processor==$i && strlen($processor) > 0) ||
                      ($i==1 && strlen($processor) < 1 && !isset($_GET['active_terminal'])) ||
                      (isset($_GET['active_terminal']) && $i==$_GET['active_terminal'])
            ? ' selected' : '');
        return $condition;
    }

    protected function isPluginFilter($fieldName)
    {
        if(strpos($fieldName, '[filter]') === false){
            return null;
        } else {
            return str_replace('[filter]','', $fieldName);
        }
    }

    protected function displayErrors($array)
    {
        foreach($array as $terminal => $error){
            foreach($error as $key => $errorText){
                echo "ERROR :".$errorText."<br />";
            }
        }
    }

}