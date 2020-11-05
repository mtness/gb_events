<?php
if (!defined('TYPO3_MODE')) {
    die('Access denied.');
}

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
    'In2code.GbEvents',
    'Main',
    [
        'Event' => 'list, show',
        'Archive' => 'list',
        'Calendar' => 'show',
        'Export' => 'list, show',
    ]
);

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
    'In2code.GbEvents',
    'Upcoming',
    [
        'Upcoming' => 'list',
    ]
);

$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['ext/install']['update']['eventSlug']
    = \In2code\GbEvents\Updates\EventSlugUpdater::class;

// ke_search indexer
if (\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::isLoaded('ke_search')) {
    $GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['ke_search']['registerIndexerConfiguration'][] =
        'EXT:gb_events/Classes/Hooks/EventIndexer.php:' . \In2code\GbEvents\Hooks\EventIndexer::class;
    $GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['ke_search']['customIndexer'][] =
        \In2code\GbEvents\Hooks\EventIndexer::class;
}
