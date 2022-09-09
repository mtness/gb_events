<?php
namespace In2code\GbEvents\Controller;

use Psr\Http\Message\ResponseInterface;
use TYPO3\CMS\Extbase\Http\ForwardResponse;
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
     *
     */
    public function listAction(): ResponseInterface
    {
        switch ($this->settings['displayMode']) {
            case 'calendar':
                return (new ForwardResponse('show'))->withControllerName('Calendar');

                return $this->htmlResponse(null);
                break;
            case 'archive':
                return (new ForwardResponse('list'))->withControllerName('Archive');

                return $this->htmlResponse(null);
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
        return $this->htmlResponse();
    }

    /**
     * Displays a single Event
     *
     * @param Event $event
     * @return void
     */
    public function showAction(Event $event): ResponseInterface
    {
        $this->addCacheTags($event, 'tx_gbevents_domain_model_event');
        $this->view->assign('event', $event);
        return $this->htmlResponse();
    }
}
