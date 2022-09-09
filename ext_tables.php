<?php
use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;

call_user_func(
    function () {
        defined('TYPO3') || die();

        ExtensionManagementUtility::addLLrefForTCAdescr(
            'tx_gbevents_domain_model_event',
            'EXT:gb_events/Resources/Private/Language/locallang_csh_tx_gbevents_domain_model_event.xlf'
        );
        ExtensionManagementUtility::allowTableOnStandardPages('tx_gbevents_domain_model_event');
    }
);
