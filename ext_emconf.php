<?php

$EM_CONF[$_EXTKEY] = [
    'title' => 'Event calendar',
    'description' => 'A simple calendar for upcoming events.',
    'category' => 'plugin',
    'author' => 'Sebastian Stein',
    'author_email' => 'sebastian.stein@in2code.de',
    'author_company' => 'In2code GmbH',
    'state' => 'stable',
    'clearCacheOnLoad' => 1,
    'version' => '9.0.2',
    'constraints' => [
        'depends' => [
            'php' => '^7.0',
            'typo3' => '8.7.0-9.5.99',
        ],
    ],
    'autoload' => [
        'psr-4' => [
            'In2code\\GbEvents\\' => 'Classes',
        ],
    ]
];
