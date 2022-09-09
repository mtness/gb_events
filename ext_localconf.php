<?php
use TYPO3\CMS\Extbase\Utility\ExtensionUtility;
use In2code\GbEvents\Controller\EventController;
use In2code\GbEvents\Controller\ArchiveController;
use In2code\GbEvents\Controller\CalendarController;
use In2code\GbEvents\Controller\ExportController;
use In2code\GbEvents\Controller\UpcomingController;
use In2code\GbEvents\Updates\EventSlugUpdater;
use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;
use In2code\GbEvents\Hooks\EventIndexer;

call_user_func(
    function () {
        defined('TYPO3') || die();

        ExtensionUtility::configurePlugin(
            'GbEvents',
            'Main',
            [
                EventController::class => 'list, show',
                ArchiveController::class => 'list',
                CalendarController::class => 'show',
                ExportController::class => 'list, show',
            ]
        );

        ExtensionUtility::configurePlugin(
            'GbEvents',
            'Upcoming',
            [
                UpcomingController::class => 'list',
            ]
        );

        $GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['ext/install']['update']['eventSlug'] = EventSlugUpdater::class;

        // ke_search indexer
        if (ExtensionManagementUtility::isLoaded('ke_search')) {
            $GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['ke_search']['registerIndexerConfiguration'][] =
                'EXT:gb_events/Classes/Hooks/EventIndexer.php:' . EventIndexer::class;
            $GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['ke_search']['customIndexer'][] =
                EventIndexer::class;
        }
    }
);
