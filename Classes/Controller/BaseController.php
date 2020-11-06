<?php
namespace In2code\GbEvents\Controller;

use In2code\GbEvents\Domain\Repository\EventRepository;
use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;
use TYPO3\CMS\Extbase\Persistence\Generic\Mapper\DataMapper;
use TYPO3\CMS\Frontend\Controller\TypoScriptFrontendController;

/**
 * ArchiveController
 */
abstract class BaseController extends ActionController
{
    /**
     * @var \In2code\GbEvents\Domain\Repository\EventRepository
     */
    protected $eventRepository;

    /**
     * @var DataMapper
     */
    protected $dataMapper;

    /**
     * inject the eventRepository
     *
     * @param \In2code\GbEvents\Domain\Repository\EventRepository eventRepository
     * @return void
     */
    public function injectEventRepository(EventRepository $eventRepository)
    {
        $this->eventRepository = $eventRepository;
    }

    /**
     * Dynamically add the right tags to the page cache for a details or list view
     *
     * @param mixed $items
     * @param string|array $additionalTags
     */
    protected function addCacheTags($items, $additionalTags = null)
    {
        if (TYPO3_MODE === 'BE') {
            return;
        }

        if (!is_array($items) && !$items instanceof \Traversable && !$items instanceof \ArrayAccess) {
            $items = [$items];
        }
        if (!is_array($additionalTags)) {
            $additionalTags = [(string)$additionalTags];
        }

        $tags = $additionalTags;
        foreach ($items as $item) {
            if ($item instanceof AbstractEntity) {
                $table = $this->getDataMapper()->convertClassNameToTableName(get_class($item));
                $uid = $item->getUid();
                $tags[] = sprintf('%s_%s', $table, $uid);
            } elseif ((string)$item !== '') {
                $tags[] = (string)$item;
            }
        }

        if (!empty($tags)) {
            $this->getTypoScriptFrontEndController()->addCacheTags($tags);
        }
    }

    /**
     * @return DataMapper
     */
    protected function getDataMapper()
    {
        if (!isset($this->dataMapper)) {
            $this->dataMapper = $this->objectManager->get(DataMapper::class);
        }

        return $this->dataMapper;
    }

    /**
     * @return TypoScriptFrontendController
     */
    protected function getTypoScriptFrontEndController()
    {
        return $GLOBALS['TSFE'];
    }
}
