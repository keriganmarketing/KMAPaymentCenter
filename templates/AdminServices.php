<?php /*
 Admin Services
 */
use KMAPaymentCenter\PluginConfig;
?>
<link rel="stylesheet" media="screen" href="<?php echo get_site_url(); ?>/wp-content/plugins/KMAPaymentCenter/css/admin-style.css" />
<?php

$kmapcServicesTitle = get_option('kmapc_services_title');
$kmapcServicesDesc  = get_option('kmapc_services_desc');
//form submitted
if(isset($_POST['kmapc_submit_settings']) && $_POST['kmapc_submit_settings'] == 'yes'){
    update_option('kmapc_services_title', isset($_POST['kmapc_services_title']) ? stripslashes($_POST['kmapc_services_title']) : $kmapcServicesTitle);

}

?>
<script type="text/javascript">
    jQuery(document).ready(function($){
        $('.toggle-recurring').click(function(){
            if($(this).val() == 'on') {
                $('#recurringDiv')[0].style.display = "block";
            }else{
                $('#recurringDiv')[0].style.display = "none";
            }
        });
    });
</script>
<div class="page-wrapper" style="margin-left:-20px;">
    <div class="hero is-dark">
        <div class="hero-body">
            <div class="columns is-vcentered">
                <div class="column">
                    <p class="title">
                        Services
                    </p>
                </div>
                <div class="column is-narrow">
                    <?php include('KMASig.php'); ?>
                </div>
            </div>
        </div>
    </div>
    <section class="section">
        <div class="container is-fluid">
            <div class="content">
                <?php _e("Here you create and manage basic list of products, services or events you'd like to accept payments for." ); ?>
                <form name="kmapc_form" method="post" action="<?php echo str_replace( '%7E', '~', $_SERVER['REQUEST_URI']); ?>">

                    <div class="editor-wrapper">
                        <h4 class="wp-heading-inline">Add New Service</h4>
                        <p class="subtitle">This is what customers will see in the services dropdown to select from when they decide to pay.</p><br>
                        <div class="control">
                            <input type="text"  class="input" name="kmapc_services_title" value="<?php echo $kmapcServicesTitle; ?>" placeholder="Service Name">
                        </div>
                        <br>

                        <label class="label" for="kmapc_services_recurring" >Is recurring service?</label>
                        <div class="control">
                            <label class="radio">
                                <input type="radio" class="toggle-recurring" value="on" name="kmapc_services_recurring"> Yes
                            </label>
                            <label class="radio">
                                <input type="radio" class="toggle-recurring" value="off" name="kmapc_services_recurring" checked> No
                            </label>
                        </div>
                        <br>

                        <div id="recurringDiv" style="display:none;">
                            <label class="label">Billing period</label>
                            <div class="columns is-multiline">
                                <div class="column is-narrow">
                                    <div class="control">
                                        <div class="select">
                                            <select name="kmapc_services_recurring_period_number">
                                                <?php
                                                for($i=1;$i<31;$i++)
                                                {
                                                    ?>
                                                    <option><?php echo $i;?></option>
                                                    <?php
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="column is-narrow">
                                    <div class="control">
                                        <div class="select">
                                            <select name="kmapc_services_recurring_period_type">
                                                <option value="days">Days</option>
                                                <option value="months">Months</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <label class="label" for="kmapc_services_price" >Amount to charge (numbers only)</label>
                        <div class="field has-addons">
                            <p class="control">
                                <a class="button is-static">
                                    $
                                </a>
                            </p>
                            <p class="control">
                                <input type="text"  class="input" name="kmapc_services_price" value="<?php  ?>" >
                            </p>
                        </div>
                        <br>

                        <label class="label" for="kmapc_services_descr" >Service Description</label>
                        <div class="<?php echo user_can_richedit() ? 'postdivrich' : 'postdiv'; ?>" >
                            <?php wp_editor($kmapcServicesDesc, $editor_id = 'kmapc_services_descr',
                                $settings = [
                                    'textarea_name' => 'kmapc_services_descr',
                                    'media_buttons' => false,
                                    'editor_height' => 150
                                ]
                            ); ?>
                        </div>
                        <br>



                    </div>

                </form>
            </div>
        </div>
    </section>
</div>