<?php

//REQUEST VARIABLES
$item_description = ( ! empty($_REQUEST["item_description"])) ? strip_tags(str_replace("'", "`", $_REQUEST["item_description"])) : '';
$amount           = ( ! empty($_REQUEST["amount"])) ? strip_tags(str_replace("'", "`", $_REQUEST["amount"])) : '';
$invoiceamount    = ( ! empty($_REQUEST["invoiceamount"])) ? strip_tags(str_replace("'", "`", $_REQUEST["invoiceamount"])) : '';
$invoicenumber    = ( ! empty($_REQUEST["invoicenumber"])) ? strip_tags(str_replace("'", "`", $_REQUEST["invoicenumber"])) : '';
$patientname      = ( ! empty($_REQUEST["patientname"])) ? strip_tags(str_replace("'", "`", $_REQUEST["patientname"])) : '';
$patientnumber    = ( ! empty($_REQUEST["patientnumber"])) ? strip_tags(str_replace("'", "`", $_REQUEST["patientnumber"])) : '';
$fname            = ( ! empty($_REQUEST["fname"])) ? strip_tags(str_replace("'", "`", $_REQUEST["fname"])) : '';
$lname            = ( ! empty($_REQUEST["lname"])) ? strip_tags(str_replace("'", "`", $_REQUEST["lname"])) : '';
$email            = ( ! empty($_REQUEST["email"])) ? strip_tags(str_replace("'", "`", $_REQUEST["email"])) : '';
$address          = ( ! empty($_REQUEST["address"])) ? strip_tags(str_replace("'", "`", $_REQUEST["address"])) : '';
$city             = ( ! empty($_REQUEST["city"])) ? strip_tags(str_replace("'", "`", $_REQUEST["city"])) : '';
$country          = ( ! empty($_REQUEST["country"])) ? strip_tags(str_replace("'", "`", $_REQUEST["country"])) : 'US';
$state            = ( ! empty($_REQUEST["state"])) ? strip_tags(str_replace("'", "`", $_REQUEST["state"])) : '';
$zip              = ( ! empty($_REQUEST["zip"])) ? strip_tags(str_replace("'", "`", $_REQUEST["zip"])) : '';
$serviceID        = ( ! empty($_REQUEST['serviceID'])) ? strip_tags(str_replace("'", "`", strip_tags($_REQUEST['serviceID']))) : '';
$service          = ( ! empty($_REQUEST['service'])) ? strip_tags(str_replace("'", "`", strip_tags($_REQUEST['service']))) : $serviceID;

?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bulma/0.6.2/css/bulma.min.css">
<style>
    .pane {
        padding: 2rem 0;
        border-bottom: 1px solid #DDD;
        margin-bottom: 2rem;
    }
    #serviceamount {
        min-width: unset;
        max-width: unset;
        width: 85px;
        font-weight: bold;
        text-align: right;
    }
    #invoiceamount {
        font-weight: bold;
        text-align: right;
    }
</style>
<script type="text/javascript">
    jQuery(document).ready(function($){
        $('#whattopay').change(function(){
            if($(this).val() == 'invoice') {
                $('#payinvoice')[0].style.display = "flex";
                $('#recurringservice')[0].style.display = "none";
            }else{
                $('#payinvoice')[0].style.display = "none";
                $('#recurringservice')[0].style.display = "flex";
            }
        });

        $('#selectservice').change(function(){
            //console.info(this.options);
            let key = this.value;

            let id = this.options[key].dataset.id,
                price = this.options[key].dataset.price,
                term = this.options[key].dataset.term,
                termtype = this.options[key].dataset.termType;

            console.info(this.options[key].dataset);
            $('#serviceamount').val(price);
            if(term == 1){
                if(termtype == 'months'){
                    $('#serviceterm').html('per month');
                }
                if(termtype == 'days'){
                    $('#serviceterm').html('per day');
                }
                if(termtype == 'years'){
                    $('#serviceterm').html('per year');
                }
            }else{
                $('#serviceterm').html('every ' + term + ' ' + termtype);
            }


        });

    });
</script>
<form id="ff1" name="ff1" method="post" action="" enctype="multipart/form-data" class="anpt_form">
    <h2 class="title current">Payment Information</h2>
    <div class="pane">
        <div class="columns is-multiline">
            <div class="column is-12" >
                <label class="label">What would you like to pay for?</label>
                <div class="field">
                    <div class="control">
                        <div class="select">
                            <select name="whattopay" id="whattopay" class="select" >
                                <option value="" >Select one</option>
                                <option value="invoice">Pay an invoice</option>
                                <option value="recurring-service">Recurring services</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div id="recurringservice" class="columns is-multiline" style="display: none;">
	        <?php
	        $paymentServices = new KMAPaymentCenter\PaymentServices();
	        $currentServices = $paymentServices->getServices();
	        //echo '<pre>',print_r($currentServices[0]),'</pre>';

	        $serviceOptions = '';
	        for( $key = 0; $key <= count($currentServices); $key++){
	            $serviceOptions .= '<option data-id="' . $currentServices[$key]->kmapc_services_id . '" value="' . ((int)$key+1) . '" 
	            data-term="' . $currentServices[$key]->kmapc_services_recurring_period_number . '"
	            data-term-type="' . $currentServices[$key]->kmapc_services_recurring_period_type . '"
	            data-price="' . $currentServices[$key]->kmapc_services_price . '" >' . $currentServices[$key]->kmapc_services_title . '</option>';
            }

	        ?>
            <div class="column is-6" >
                <label class="label">Service:</label>
                <div class="field">
                    <div class="control">
                        <div class="select">
                            <select id="selectservice" class="select" >
                                <option value="" >Select one</option>
                                <?php echo $serviceOptions; ?>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="column is-6" >
                <label class="label">Amount:</label>
                <div class="field has-addons">
                    <p class="control">
                        <a class="button is-static">$</a>
                    </p>
                    <p class="control">
                        <input name="serviceamount" id="serviceamount" type="text" class="input small-field" readonly value="" />
                    </p>
                    <p class="control">
                        <a class="button is-static" id="serviceterm"></a>
                    </p>
                </div>
                <input type="hidden" name="serviceterm" id="serviceterm" value="">
                <input type="hidden" name="servicetermtype" id="servicetermtype" value="">
            </div>
        </div>
        <div id="payinvoice" class="columns is-multiline" style="display: none;">
            <div class="column is-6" >
                <label class="label">Invoice number:</label>
                <div class="field">
                    <p class="control">
                        <input name="invoicenumber" id="invoicenumber" type="text" class="input small-field" value="<?php echo $invoicenumber; ?>" />
                    </p>
                </div>
            </div>
            <div class="column is-6" >
                <label class="label">Amount:</label>
                <div class="field has-addons">
                    <p class="control">
                        <a class="button is-static">$</a>
                    </p>
                    <p class="control">
                        <input name="invoiceamount" id="invoiceamount" type="text" class="input small-field" value="<?php echo $invoiceamount; ?>" />
                    </p>
                </div>
            </div>
        </div>
    </div>

    <h2 class="title">Credit Card Information</h2>
    <div class="pane">
        <div class="columns is-multiline">
            <div class="column is-12">
                <label class="label"> I have:</label>
                <div class="control">
                    <label style="display: inline-block; padding: .5rem 1.5rem .5rem 0;">
                        <input name="cctype" type="radio" value="V" class="lft-field"  style="margin:2px; vertical-align: middle"/>
                        <img src="<?php echo $imageDir; ?>/ico_visa.jpg" align="absmiddle" class="lft-field cardhide V"/>
                    </label>
                    <label style="display: inline-block; padding: .5rem 1.5rem .5rem 0;">
                        <input name="cctype" type="radio" value="M" class="lft-field"  style="margin:2px; vertical-align: middle"/>
                        <img src="<?php echo $imageDir; ?>/ico_mc.jpg" align="absmiddle" class="lft-field cardhide M"/>
                    </label>
                    <label style="display: inline-block; padding: .5rem 1.5rem .5rem 0;">
                        <input name="cctype" type="radio" value="A" class="lft-field"  style="margin:2px; vertical-align: middle"/>
                        <img src="<?php echo $imageDir; ?>/ico_amex.jpg" align="absmiddle" class="lft-field cardhide A"/>
                    </label>
                    <label style="display: inline-block; padding: .5rem 1.5rem .5rem 0;">
                        <input name="cctype" type="radio" value="D" class="lft-field"  style="margin:2px; vertical-align: middle"/>
                        <img src="<?php echo $imageDir; ?>/ico_disc.jpg" align="absmiddle" class="lft-field cardhide D"/>
                    </label>
                </div>
            </div>
            <div class="column is-5">

                <label class="label">Card Number:</label>
                <div class="control">
                    <input name="ccn" id="ccn" type="text" class="input long-field"
                           onkeyup="checkNumHighlight(this.value);checkFieldBack(this);noAlpha(this);" value=""
                           onkeypress="checkNumHighlight(this.value);noAlpha(this);" onblur="checkNumHighlight(this.value);"
                           onchange="checkNumHighlight(this.value);" maxlength="16"/>
                    <span class="ccresult"></span>
                </div>

            </div>
            <div class="column is-narrow">
                <label class="label">Expiration Date:</label>
                <div class="control">
                    <div class="select">
                        <select name="exp1" id="exp1" class="small-field" onchange="checkFieldBack(this);">
                            <option value="01">01</option>
                            <option value="02">02</option>
                            <option value="03">03</option>
                            <option value="04">04</option>
                            <option value="05">05</option>
                            <option value="06">06</option>
                            <option value="07">07</option>
                            <option value="08">08</option>
                            <option value="09">09</option>
                            <option value="10">10</option>
                            <option value="11">11</option>
                            <option value="12">12</option>
                        </select>
                    </div>
                    <div class="select">
                        <select name="exp2" id="exp2" class="small-field" onchange="checkFieldBack(this);">
							<?php for($i=date("Y");$i<date("Y", strtotime(date("Y")." +10 years"));$i++){
								echo '<option value="'.$i.'">'.$i.'</option>';
							} ?>
                        </select>
                    </div>
                </div>
            </div>
            <div class="column is-3">
                <label class="label">CVV:</label>
                <div class="field">
                    <div class="control">
                        <input name="cvv" id="cvv" type="text" maxlength="5" class="input small-field" onkeyup="checkFieldBack(this);noAlpha(this);"/>
                    </div>
                </div>
            </div>
            <div class="column is-12">
                <label class="label">Name on Card:</label>
                <div class="control">
                    <input name="ccname" id="ccname" type="text" class="input long-field" onkeyup="checkFieldBack(this);"/>
                </div>
                <p>&nbsp;</p>
            </div>

        </div>

    </div>

    <h2 class="title">Billing Information</h2>
    <div class="pane">
        <div class="columns is-multiline">
            <div class="column is-4">
                <label class="label">First Name:</label>
                <input name="fname" id="fname" type="text" class="input long-field" value="<?php echo $fname; ?>"
                       onkeyup="checkFieldBack(this);"/>
            </div>
            <div class="column is-4">
                <label class="label">Last Name:</label>
                <input name="lname" id="lname" type="text" class="input long-field" value="<?php echo $lname; ?>"
                       onkeyup="checkFieldBack(this);"/>
            </div>
            <div class="column is-4">
                <label class="label">E-mail:</label>
                <input name="email" id="email" type="text" class="input long-field" value="<?php echo $email; ?>"
                       onkeyup="checkFieldBack(this);"/>
            </div>

            <div class="column is-8">
                <label class="label">Address:</label>
                <input name="address" id="address" type="text" class="input long-field" value="<?php echo $address; ?>"
                       onkeyup="checkFieldBack(this);"/>
            </div>

            <div class="column is-4">
                <label class="label">City:</label>
                <input name="city" id="city" type="text" class="input long-field" value="<?php echo $city; ?>"
                       onkeyup="checkFieldBack(this);"/>
            </div>
            <div class="column is-4">
                <label class="label">State/Province:</label>
                <div class="control">
                    <div class="select is-fullwidth">
                        <select style="width:250px;" name="state" id="state" class="long-field" onchange="checkFieldBack(this);">
							<?php include('inc/state-select.php'); ?>
                        </select>
                    </div>
                </div>
            </div>
            <div class="column is-4">
                <label class="label">ZIP/Postal Code:</label>
                <input name="zip" id="zip" type="text" class="input small-field" value="<?php echo $zip; ?>"
                       onkeyup="checkFieldBack(this);"/>
            </div>
            <div class="column is-4">
                <label class="label">Country:</label>
                <div class="control">
                    <div class="select is-fullwidth">
                        <select style="width:250px;" name="country" id="country" class="long-field" onchange="checkFieldBack(this);">
							<?php include('inc/country-select.php'); ?>
                        </select>
                    </div>
                </div>
            </div>
        </div>

        <div class="columns is-multiline">
            <div class="column is-12">
                <input type="hidden" name="process" value="yes" />
                <div class="submit-btn">
                    <button type="submit" name="submit" class="button is-primary" <?php if ($form->anpt_enable_captcha){ ?>disabled<?php } ?> >Submit Payment</button>
                </div>
            </div>
        </div>
    </div>
</form>