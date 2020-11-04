<?php
namespace In2code\GbEvents\Controller;

/**
 * UpcomingController
 */
class UpcomingController extends BaseController
{
    /**
     * Displays all Events
     *
     * @return void
     */
    public function listAction()
    {
        $events = $this->eventRepository->findUpcoming(
            $this->settings['limit'],
            (bool)$this->settings['showStartedEvents'],
            $this->settings['categories']
        );
        $this->addCacheTags($events, 'tx_gbevents_domain_model_event');
        $this->view->assign('events', $events);
    }
}
