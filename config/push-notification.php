<?php

return array(

    'appNameIOS'     => array(
        'environment' => 'development',
        'certificate' => app_path() . '/PushNotifications/ck.pem',
        'passPhrase'  => env('PUSH_APNS_PASSPHRASE'),
        'service'     => 'apns'
    ),
//    'appNameAndroid' => array(
//        'environment' => 'production',
//        'apiKey'      => 'yourAPIKey',
//        'service'     => 'gcm'
//    )

);