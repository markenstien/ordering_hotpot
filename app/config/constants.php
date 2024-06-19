<?php

    #################################################
	##             THIRD-PARTY APPS                ##
    #################################################

    define('DEFAULT_REPLY_TO' , '');

    const MAILER_AUTH = [
        'username' => 'cx@hotplate.one',
        'password' => 'zK9!0*#IDO7z',
        'host'     => 'hotplate.one',
        'name'     => 'Hotplate',
        'replyTo'  => 'cx@hotplate.one',
        'replyToName' => 'Hotplate'
    ];



    const ITEXMO = [
        'key' => '',
        'pwd' => ''
    ];

	#################################################
	##             SYSTEM CONFIG                ##
    #################################################


    define('GLOBALS' , APPROOT.DS.'classes/globals');

    define('SITE_NAME' , 'hotplate.one');

    define('COMPANY_NAME' , 'Hotplate');

    define('COMPANY_NAME_ABBR', 'hotplate');
    define('COMPANY_EMAIL', 'main@hotplate.store');
    define('COMPANY_TEL', '+');
    define('COMPANY_ADDRESS', ' ');

    

    define('KEY_WORDS' , 'Hotplate,Ordering System');

    define('DESCRIPTION' , '#############');
    define('AUTHOR' , 'Hotplate Ordering System');
    define('APP_KEY' , 'Hotplate-5175140471');
    
?>