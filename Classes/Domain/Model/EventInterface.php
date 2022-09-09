<?php
namespace In2code\GbEvents\Domain\Model;

use DateTime;
use TYPO3\CMS\Extbase\Persistence\ObjectStorage;

/**
 * A single event
 */
interface EventInterface
{
    /**
     * @param string $title
     * @return void
     */
    public function setTitle($title);

    /**
     * @return string
     */
    public function getTitle();

    /**
     * @param string $teaser
     * @return void
     */
    public function setTeaser($teaser);

    /**
     * @return string
     */
    public function getTeaser();

    /**
     * @param string $description
     * @return void
     */
    public function setDescription($description);

    /**
     * @return string
     */
    public function getDescription();

    /**
     * Get plain description with no HTML
     *
     * @return string
     */
    public function getPlainDescription();

    /**
     * @param string $location
     * @return void
     */
    public function setLocation($location);

    /**
     * @return string
     */
    public function getLocation();

    /**
     * @param DateTime $eventDate
     * @return void
     */
    public function setEventDate(DateTime $eventDate);

    /**
     * This only returns the initial event date
     *
     * @return DateTime
     */
    public function getEventDate();

    /**
     * This returns the initial event dates including
     * all recurring events up to and including the
     * stopDate, taking the defined end of recurrance
     * into account
     *
     * @param DateTime $startDate
     * @param DateTime $stopDate
     */
    public function getEventDates(DateTime $startDate, DateTime $stopDate);

    /**
     * @param string $eventTime
     * @return void
     */
    public function setEventTime($eventTime);

    /**
     * @return string
     */
    public function getEventTime();

    /**
     * @param string $images
     * @return void
     */
    public function setImages($images);

    /**
     * @return ObjectStorage<FileReference>
     */
    public function getImages();

    /**
     * @param string $downloads
     * @return void
     */
    public function setDownloads($downloads);

    /**
     * @return ObjectStorage<FileReference>
     */
    public function getDownloads();

    /**
     * @param int $recurringWeeks
     * @return void
     */
    public function setRecurringWeeks($recurringWeeks);

    /**
     * @return int
     */
    public function getRecurringWeeks();

    /**
     * @param int $recurringDays
     * @return void
     */
    public function setRecurringDays($recurringDays);

    /**
     * @return int
     */
    public function getRecurringDays();

    /**
     * @param DateTime $recurringStop
     * @return void
     */
    public function setRecurringStop($recurringStop);

    /**
     * @return DateTime
     */
    public function getRecurringStop();

    /**
     * @param bool $recurringExcludeHolidays
     * @return void
     */
    public function setRecurringExcludeHolidays($recurringExcludeHolidays);

    /**
     * @return bool
     */
    public function getRecurringExcludeHolidays();

    /**
     * @param string $recurringExcludeDates
     * @return void
     */
    public function setRecurringExcludeDates($recurringExcludeDates);

    /**
     * @return string
     */
    public function getRecurringExcludeDates();

    /**
     * Set the event stop date
     *
     * @param DateTime $eventStopDate
     * @return void
     */
    public function setEventStopDate($eventStopDate);

    /**
     * Get the event stop date
     *
     * @return DateTime
     */
    public function getEventStopDate();

    /**
     * Returns a unique identifier
     *
     * @return string
     */
    public function getUniqueIdentifier();

    /**
     * Returns the event duration in seconds
     *
     * @return int
     */
    public function getDuration();
}
