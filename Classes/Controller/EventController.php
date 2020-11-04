<?php
namespace In2code\GbEvents\Controller;

use In2code\GbEvents\Domain\Model\Event;
use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * Controller for the Event object
 */
class EventController extends BaseController
{
    /**
     * Displays all Events
     *
     * @return void
     */
    public function listAction()
    {
        switch ($this->settings['displayMode']) {
            case 'calendar':
                $this->forward('show', 'Calendar');

                return;
                break;
            case 'archive':
                $this->forward('list', 'Archive');

                return;
                break;
            default:
                $events = $this->eventRepository->findAll(
                    $this->settings['years'],
                    (bool)$this->settings['showStartedEvents'],
                    $this->settings['categories']
                );
                $this->addCacheTags($events, 'tx_gbevents_domain_model_event');
                $this->view->assign('events', $events);
        }
    }

    /**
     * Displays a single Event
     *
     * @param Event $event
     * @return void
     */
    public function showAction(Event $event)
    {
        $this->addCacheTags($event, 'tx_gbevents_domain_model_event');
        $this->view->assign('event', $event);
    }
}
