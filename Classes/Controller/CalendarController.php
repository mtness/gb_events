<?php
namespace In2code\GbEvents\Controller;

/**
 * Controller for the calendar view
 */
class CalendarController extends BaseController
{
    /**
     * Displays all events as a browseable calendar
     *
     * @param  string $start
     * @return void
     */
    public function showAction($start = 'today')
    {
        // Startdatum setzen
        $startDate = new \DateTime('today');
        try {
            $startDate->modify($start);
        } catch (\Exception $e) {
            $startDate->modify('midnight');
        }

        // Start für Kalenderanzeige bestimmen
        $preDate = clone($startDate);
        if ($startDate->format('N') !== 1) {
            $preDate->modify('last monday of previous month');
        }

        // Ende des Monats bestimmen
        $stopDate = clone($startDate);
        $stopDate->modify('last day of this month');
        $stopDate->modify('+86399 seconds');

        $postDate = clone($stopDate);
        if ($stopDate->format('N') !== 7) {
            $postDate->modify('next sunday');
        }

        // Navigational dates
        $nextMonth = clone($startDate);
        $nextMonth->modify('first day of next month');
        $previousMonth = clone($startDate);
        $previousMonth->modify('first day of previous month');

        $days = [];
        $runDate = clone($preDate);
        while ($runDate <= $postDate) {
            $days[$runDate->format('Y-m-d')] = [
                'date' => clone($runDate),
                'events' => [],
                'disabled' => (($runDate < $startDate) || ($runDate > $stopDate)),
            ];
            $runDate->modify('tomorrow');
        }

        $events = $this->eventRepository->findAllBetween(
            $preDate,
            $postDate,
            false,
            $this->settings['categories']
        );
        foreach ($events as $eventDay => $eventsThisDay) {
            $days[$eventDay]['events'] = $eventsThisDay['events'];
        }

        $weeks = [];
        $visibleWeeks = floor(count($days) / 7);
        for ($i = 0; $i < $visibleWeeks; $i++) {
            $weeks[] = array_slice($days, $i * 7, 7, true);
        }

        $this->addCacheTags($events, 'tx_gbevents_domain_model_event');
        $this->view->assignMultiple([
            'calendar' => $weeks,
            'navigation' => [
                'previous' => $previousMonth,
                'current' => $startDate,
                'next' => $nextMonth,
            ],
            'nextMonth' => $nextMonth->format('Y-m-d'),
            'prevMonth' => $previousMonth->format('Y-m-d'),
        ]);
    }
}
