<?php
namespace KMAPaymentCenter;

class ProcessSubmission
{
    public function __construct()
    {
        $validator = new FormValidation();
        if ($validator->valid === false) {
            $this->showError($validator->errors);
        } else {
            $payment = new ProcessPayment();
            if ($payment->return['RESPONSE'] == 'OK') {
                $this->showSuccess($payment->return['details']);
            } elseif ($payment->return['RESPONSE'] == 'ERROR') {
                $this->showError($payment->return['details']['errors']);
            }
        }
    }

    protected function showSuccess($message)
    {
        echo '<div style="padding:1rem; color: green; background-color: rgba(0,255,0,.1); border: 1px solid green; margin: 1rem 0;" >
                <p>' . $message['description'] . ' You will receive an email receipt and your transaction ID is ' . $message['transaction_id'] . '.</p>
              </div>';
    }

    protected function showError($errors)
    {
        echo '<div style="padding:1rem; color: red; background-color: rgba(255,0,0,.1); border: 1px solid red; margin: 1rem 0;" ><p>There were errors in your submission. Please check the following and retry your payment.</p><ul>';
        foreach ($errors as $key => $error) {
            echo '<li>' . (! is_numeric($key) ? $key . ':' : '') . $error . '</li>';
        }
        echo '</ul></div>';
    }
}