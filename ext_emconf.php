<?php

$EM_CONF[$_EXTKEY] = [
    'title' => 'Event calendar',
    'description' => 'A simple calendar for upcoming events',
    'category' => 'plugin',
    'author' => 'Sebastian Stein',
    'author_email' => 'sebastian.stein@in2code.de',
    'author_company' => 'In2code GmbH',
    'state' => 'stable',
    'version' => '12.0.0',
    'constraints' => [
        'depends' => [
            'php' => '8.1.0-8.9.99',
            'typo3' => '12.4.0-13.4.99',
        ],
    ],
    'autoload' => [
        'psr-4' => [
            'In2code\\GbEvents\\' => 'Classes',
        ],
    ]
];
