<?php

/*********************************************************************
 * Extension configuration file for ext "gb_events".
 *
 * Generated by ext 17-09-2014 07:49 UTC
 *
 * https://github.com/t3elmar/Ext
 *********************************************************************/

$EM_CONF['gb_events'] = [
    'title' => 'Event calendar',
    'description' => 'A simple calendar for upcoming events.',
    'category' => 'plugin',
    'author' => 'Morton Jonuschat',
    'author_email' => 'm.jonuschat@gute-botschafter.de',
    'author_company' => 'Gute Botschafter GmbH',
    'shy' => '',
    'dependencies' => 'extbase,fluid',
    'conflicts' => '',
    'priority' => '',
    'module' => '',
    'state' => 'stable',
    'internal' => '',
    'uploadfolder' => '1',
    'createDirs' => '',
    'modify_tables' => '',
    'clearCacheOnLoad' => 0,
    'lockType' => '',
    'version' => '6.2.4',
    'constraints' => [
        'depends' => [
            'typo3' => '6.2.0-7.6.99',
        ],
        'conflicts' => [
        ],
        'suggests' => [
        ],
    ],
    'comment' => 'Make it possible to show events that have started but not yet finished.',
    'user' => 'gutebotschafter',
];

?>
