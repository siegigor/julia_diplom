<?php
return [
    'components' => [
        'db' => [
            'class' => 'yii\db\Connection',
            'dsn' => 'mysql:host=localhost;dbname=tptohwig_diplomjulia',
            'username' => 'tptohwig_igor',
            'password' => 'Ilovematan1488',
            'charset' => 'utf8',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            'viewPath' => '@common/mail',
            'useFileTransport' => false,
            'transport' => [
                 'class' => 'Swift_SmtpTransport',
                 'host' => 'mail.require-once.com',  // e.g. smtp.mandrillapp.com or smtp.gmail.com
                 'username' => 'admin@require-once.com',
                 'password' => 'Ilovematan1488',
                 'port' => '25',
             ],
        ],
    ],
];
