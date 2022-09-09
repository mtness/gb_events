<?php

declare(strict_types=1);

namespace In2code\GbEvents\Updates;

use In2code\GbEvents\Service\SlugService;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Install\Updates\DatabaseUpdatedPrerequisite;
use TYPO3\CMS\Install\Updates\UpgradeWizardInterface;

class EventSlugUpdater implements UpgradeWizardInterface
{

    /**
     * @var SlugService
     */
    protected $slugService;

    /**
     * StudyCourseSlugUpdater constructor.
     */
    public function __construct()
    {
        $this->slugService =
            GeneralUtility::makeInstance(
                SlugService::class,
                'tx_gbevents_domain_model_event',
                'title',
                'path_segment'
            );
    }

    /**
     * @return string
     */
    public function getIdentifier(): string
    {
        return 'eventSlug';
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return 'Updates slug field "path_segment" of EXT:gb_events records';
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return 'Fills empty slug field "path_segment" of EXT:gb_events records with urlized title and graduation.';
    }

    /**
     * @return bool
     */
    public function executeUpdate(): bool
    {
        $this->slugService->performUpdates();
        return true;
    }

    /**
     * @return bool
     */
    public function updateNecessary(): bool
    {
        return $this->slugService->isSlugUpdateRequired();
    }

    /**
     * @return array|string[]
     */
    public function getPrerequisites(): array
    {
        return [
            DatabaseUpdatedPrerequisite::class
        ];
    }
}
