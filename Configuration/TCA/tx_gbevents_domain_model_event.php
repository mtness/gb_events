<?php

use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;

if (!defined('TYPO3')) {
    die('Access denied.');
}

$ll = 'LLL:EXT:gb_events/Resources/Private/Language/locallang_db.xlf:';

return [
    'ctrl' => [
        'title' => 'LLL:EXT:gb_events/Resources/Private/Language/locallang_db.xlf:tx_gbevents_domain_model_event',
        'label' => 'title',
        'tstamp' => 'tstamp',
        'crdate' => 'crdate',
        'versioningWS' => true,
        'origUid' => 't3_origuid',
        'languageField' => 'sys_language_uid',
        'transOrigPointerField' => 'l10n_parent',
        'transOrigDiffSourceField' => 'l10n_diffsource',
        'delete' => 'deleted',
        'enablecolumns' => [
            'disabled' => 'hidden',
            'starttime' => 'starttime',
            'endtime' => 'endtime',
        ],
        'iconfile' => 'EXT:gb_events/Resources/Public/Icons/Extension.svg',
        'searchFields' => 'title,teaser,description,location',
        'default_sortby' => 'event_date DESC',
    ],
    'types' => [
        '1' => [
            'showitem' => 'sys_language_uid,l10n_parent,l10n_diffsource,hidden,--palette--;;1,title,path_segment,teaser,description,location,event_time,--palette--;' . $ll . 'palette.date;date,images,downloads,--div--;LLL:EXT:gb_events/Resources/Private/Language/locallang_db.xlf:tx_gbevents_domain_model_event.recurring,recurring_weeks,recurring_days,recurring_stop,recurring_exclude_holidays,recurring_exclude_dates,--div--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xml:tabs.access,starttime,endtime',
        ],
    ],
    'palettes' => [
        'date' => [
            'showitem' => 'event_date,event_stop_date',
        ],
    ],
    'columns' => [
        'sys_language_uid' => [
            'exclude' => 1,
            'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.language',
            'config' => ['type' => 'language'],
        ],
        'l10n_parent' => [
            'displayCond' => 'FIELD:sys_language_uid:>:0',
            'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.l18n_parent',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'items' => [
                    ['', 0],
                ],
                'foreign_table' => 'tx_gbevents_domain_model_event',
                'foreign_table_where' => 'AND tx_gbevents_domain_model_event.pid=###CURRENT_PID### AND tx_gbevents_domain_model_event.sys_language_uid IN (-1,0)',
                'default' => 0,
            ],
        ],
        'l10n_diffsource' => [
            'config' => [
                'type' => 'passthrough',
            ],
        ],
        't3ver_label' => [
            'displayCond' => 'FIELD:t3ver_label:REQ:true',
            'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.versionLabel',
            'config' => [
                'type' => 'none',
                'cols' => 27,
            ],
        ],
        'hidden' => [
            'exclude' => 1,
            'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.hidden',
            'config' => [
                'type' => 'check',
            ],
        ],
        'starttime' => [
            'exclude' => 1,
            'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.starttime',
            'config' => [
                'type' => 'input',
                'renderType' => 'inputDateTime',
                'size' => '10',
                'eval' => 'datetime',
                'checkbox' => '0',
                'default' => '0',
                'behaviour' => [
                    'allowLanguageSynchronization' => true,
                ],
            ],
        ],
        'endtime' => [
            'exclude' => 1,
            'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.endtime',
            'config' => [
                'type' => 'input',
                'renderType' => 'inputDateTime',
                'size' => '8',
                'eval' => 'datetime',
                'checkbox' => '0',
                'default' => '0',
                'range' => [
                    'upper' => mktime(0, 0, 0, 12, 31, date('Y') + 10),
                    'lower' => mktime(0, 0, 0, date('m') - 1, date('d'), date('Y')),
                ],
                'behaviour' => [
                    'allowLanguageSynchronization' => true,
                ],
            ],
        ],
        'categories' => [
            'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.category',
            'config' => [
                'type' => 'category',
            ],
        ],
        'title' => [
            'exclude' => 0,
            'label' => 'LLL:EXT:gb_events/Resources/Private/Language/locallang_db.xlf:tx_gbevents_domain_model_event.title',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim,required',
            ],
        ],
        'path_segment' => [
            'exclude' => true,
            'label' => 'LLL:EXT:gb_events/Resources/Private/Language/locallang_db.xlf:tx_gbevents_domain_model_event.path_segment',
            'config' => [
                'type' => 'slug',
                'generatorOptions' => [
                    'fields' => ['title'],
                    'fieldSeparator' => '/',
                    'prefixParentPageSlug' => false,
                    'replacements' => [
                        '/' => '',
                    ],
                ],
                'fallbackCharacter' => '-',
                'eval' => 'uniqueInSite',
                'default' => '',
            ],
        ],
        'teaser' => [
            'exclude' => 0,
            'label' => 'LLL:EXT:gb_events/Resources/Private/Language/locallang_db.xlf:tx_gbevents_domain_model_event.teaser',
            'config' => [
                'type' => 'text',
                'cols' => 40,
                'rows' => 15,
                'eval' => 'trim',
            ],
        ],
        'description' => [
            'exclude' => 0,
            'label' => 'LLL:EXT:gb_events/Resources/Private/Language/locallang_db.xlf:tx_gbevents_domain_model_event.description',
            'config' => [
                'type' => 'text',
                'cols' => 40,
                'rows' => 15,
                'eval' => 'trim',
                'enableRichtext' => true,
            ],
        ],
        'location' => [
            'exclude' => 0,
            'label' => 'LLL:EXT:gb_events/Resources/Private/Language/locallang_db.xlf:tx_gbevents_domain_model_event.location',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim',
            ],
        ],
        'event_date' => [
            'exclude' => 0,
            'label' => 'LLL:EXT:gb_events/Resources/Private/Language/locallang_db.xlf:tx_gbevents_domain_model_event.event_date',
            'config' => [
                'type' => 'input',
                'renderType' => 'inputDateTime',
                'size' => 12,
                'eval' => 'datetime,required',
                'checkbox' => 1,
            ],
        ],
        'event_time' => [
            'exclude' => 0,
            'label' => 'LLL:EXT:gb_events/Resources/Private/Language/locallang_db.xlf:tx_gbevents_domain_model_event.event_time',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim',
            ],
        ],
        'event_stop_date' => [
            'exclude' => 0,
            'label' => 'LLL:EXT:gb_events/Resources/Private/Language/locallang_db.xlf:tx_gbevents_domain_model_event.event_stop_date',
            'config' => [
                'type' => 'input',
                'renderType' => 'inputDateTime',
                'size' => 12,
                'eval' => 'datetime,int',
                'checkbox' => 1,
            ],
        ],
        'recurring_weeks' => [
            'exclude' => 0,
            'label' => 'LLL:EXT:gb_events/Resources/Private/Language/locallang_db.xlf:tx_gbevents_domain_model_event.recurring_weeks',
            'config' => [
                'type' => 'check',
                'items' => [
                    [
                        'LLL:EXT:gb_events/Resources/Private/Language/locallang_db.xlf:tx_gbevents_domain_model_event.recurring_weeks.0',
                        '',
                    ],
                    [
                        'LLL:EXT:gb_events/Resources/Private/Language/locallang_db.xlf:tx_gbevents_domain_model_event.recurring_weeks.1',
                        '',
                    ],
                    [
                        'LLL:EXT:gb_events/Resources/Private/Language/locallang_db.xlf:tx_gbevents_domain_model_event.recurring_weeks.2',
                        '',
                    ],
                    [
                        'LLL:EXT:gb_events/Resources/Private/Language/locallang_db.xlf:tx_gbevents_domain_model_event.recurring_weeks.3',
                        '',
                    ],
                    [
                        'LLL:EXT:gb_events/Resources/Private/Language/locallang_db.xlf:tx_gbevents_domain_model_event.recurring_weeks.4',
                        '',
                    ],
                    [
                        'LLL:EXT:gb_events/Resources/Private/Language/locallang_db.xlf:tx_gbevents_domain_model_event.recurring_weeks.5',
                        '',
                    ],
                ],
            ],
        ],
        'recurring_days' => [
            'exclude' => 0,
            'label' => 'LLL:EXT:gb_events/Resources/Private/Language/locallang_db.xlf:tx_gbevents_domain_model_event.recurring_days',
            'config' => [
                'type' => 'check',
                'items' => [
                    [
                        'LLL:EXT:gb_events/Resources/Private/Language/locallang_db.xlf:tx_gbevents_domain_model_event.recurring_days.0',
                        '',
                    ],
                    [
                        'LLL:EXT:gb_events/Resources/Private/Language/locallang_db.xlf:tx_gbevents_domain_model_event.recurring_days.1',
                        '',
                    ],
                    [
                        'LLL:EXT:gb_events/Resources/Private/Language/locallang_db.xlf:tx_gbevents_domain_model_event.recurring_days.2',
                        '',
                    ],
                    [
                        'LLL:EXT:gb_events/Resources/Private/Language/locallang_db.xlf:tx_gbevents_domain_model_event.recurring_days.3',
                        '',
                    ],
                    [
                        'LLL:EXT:gb_events/Resources/Private/Language/locallang_db.xlf:tx_gbevents_domain_model_event.recurring_days.4',
                        '',
                    ],
                    [
                        'LLL:EXT:gb_events/Resources/Private/Language/locallang_db.xlf:tx_gbevents_domain_model_event.recurring_days.5',
                        '',
                    ],
                    [
                        'LLL:EXT:gb_events/Resources/Private/Language/locallang_db.xlf:tx_gbevents_domain_model_event.recurring_days.6',
                        '',
                    ],
                ],
            ],
        ],
        'recurring_stop' => [
            'exclude' => 0,
            'label' => 'LLL:EXT:gb_events/Resources/Private/Language/locallang_db.xlf:tx_gbevents_domain_model_event.recurring_stop',
            'config' => [
                'type' => 'input',
                'renderType' => 'inputDateTime',
                'size' => 12,
                'eval' => 'datetime,int',
                'checkbox' => 1,
            ],
        ],
        'recurring_exclude_holidays' => [
            'exclude' => 0,
            'label' => 'LLL:EXT:gb_events/Resources/Private/Language/locallang_db.xlf:tx_gbevents_domain_model_event.recurring_exclude_holidays',
            'config' => [
                'type' => 'check',
                'default' => 0,
            ],
        ],
        'recurring_exclude_dates' => [
            'exclude' => 0,
            'label' => 'LLL:EXT:gb_events/Resources/Private/Language/locallang_db.xlf:tx_gbevents_domain_model_event.recurring_exclude_dates',
            'config' => [
                'type' => 'text',
                'cols' => 40,
                'rows' => 15,
                'eval' => 'trim',
            ],
        ],
        'images' => [
            'exclude' => 0,
            'label' => 'LLL:EXT:gb_events/Resources/Private/Language/locallang_db.xlf:tx_gbevents_domain_model_event.images',
            'config' => [
                'type' => 'file',
                'allowed' => 'common-image-types'
            ],
        ],
        'downloads' => [
            'exclude' => 0,
            'label' => 'LLL:EXT:gb_events/Resources/Private/Language/locallang_db.xlf:tx_gbevents_domain_model_event.downloads',
            'config' => [
                'type' => 'file',
                'allowed' => 'common-file-types'
            ],
        ],
    ],
];
