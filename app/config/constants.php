<?php

    #################################################
	##             THIRD-PARTY APPS                ##
    #################################################

    define('DEFAULT_REPLY_TO' , '');

    const MAILER_AUTH = [
        'username' => 'main@medicad.store',
        'password' => 'tmKcD#t3o@Y@',
        'host'     => 'medicad.store',
        'name'     => 'Medicad',
        'replyTo'  => 'main@medicad.store',
        'replyToName' => 'Medicad'
    ];



    const ITEXMO = [
        'key' => '',
        'pwd' => ''
    ];

	#################################################
	##             SYSTEM CONFIG                ##
    #################################################


    define('GLOBALS' , APPROOT.DS.'classes/globals');

    define('SITE_NAME' , 'medicad.store');

    define('COMPANY_NAME' , 'Cadaceous Medical');

    define('COMPANY_NAME_ABBR', 'Cadaceous');
    define('COMPANY_EMAIL', 'info@medicad.store');
    define('COMPANY_TEL', '0021010101');
    define('COMPANY_ADDRESS', ' 123 Philippines at ligula 8700');

    

    define('KEY_WORDS' , 'Medicad,Ordering System');


    define('DESCRIPTION' , '#############');

    define('AUTHOR' , 'Medicad System');


    define('APP_KEY' , 'Medicad-5175140471');
    
?>