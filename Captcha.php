<?php

class Captcha{
    protected $_siteKey, $_secret;
     function __construct($siteKey, $secret)
    {
        $this->_siteKey = $siteKey;
        $this->_secret = $secret;
    }
    public function form(){
        echo '
          <div class="g-recaptcha" data-sitekey="'.$this->_siteKey.'"></div>
          <script src=\'https://www.google.com/recaptcha/api.js\'></script>
        ';
    }

    public function isPassed(){
        $curl = curl_init();
        curl_setopt_array($curl, [
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_SSL_VERIFYHOST => 0,
            CURLOPT_SSL_VERIFYPEER => 0,
            CURLOPT_URL => 'https://www.google.com/recaptcha/api/siteverify',
            CURLOPT_POST => 1,
            CURLOPT_POSTFIELDS => [
                'secret' => $this->_secret,
                'response' => $_POST['g-recaptcha-response']
            ]
        ]);

        $response = json_decode(curl_exec($curl));
        return $response->success;
    }
}
