<?php
namespace In2code\GbEvents\Controller;

use Psr\Http\Message\ResponseInterface;
/**
 * ArchiveController
 */
class ArchiveController extends BaseController
{
    /**
     * Displays all Events
     *
     * @return void
     */
    public function listAction(): ResponseInterface
    {
        $events = $this->eventRepository->findBygone($this->settings['limit'], $this->settings['categories']);
        $this->addCacheTags($events, 'tx_gbevents_domain_model_event');
        $this->view->assign('events', $events);
        return $this->htmlResponse();
    }
}
