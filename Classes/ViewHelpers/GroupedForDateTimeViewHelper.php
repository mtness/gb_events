<?php
namespace In2code\GbEvents\ViewHelpers;

use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper;

/*                                                                        *
 * This script belongs to the FLOW3 package "Fluid".                      *
 *                                                                        *
 * It is free software; you can redistribute it and/or modify it under    *
 * the terms of the GNU Lesser General Public License as published by the *
 * Free Software Foundation, either version 3 of the License, or (at your *
 * option) any later version.                                             *
 *                                                                        *
 * This script is distributed in the hope that it will be useful, but     *
 * WITHOUT ANY WARRANTY; without even the implied warranty of MERCHAN-    *
 * TABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU Lesser       *
 * General Public License for more details.                               *
 *                                                                        *
 * You should have received a copy of the GNU Lesser General Public       *
 * License along with the script.                                         *
 * If not, see http://www.gnu.org/licenses/lgpl.html                      *
 *                                                                        *
 * The TYPO3 project - inspiring people to share!                         *
 *                                                                        */

/**
 * Grouped loop view helper for Datetime values.
 * Loops through the specified values
 *
 * = Examples =
 *
 * <code title="Simple">
 * // $items = array(
 * //   array('name' => 'apple', 'start' => DateTimeObject[2011-10-13 00:15:00]),
 * //   array('name' => 'orange', 'start' => DateTimeObject[2011-12-01 00:10:00]),
 * //   array('name' => 'banana', 'start' => DateTimeObject[2008-05-24 00:40:00])
 * // );
 * <a:groupedForDateTime each="{items}" as="itemsByYear" groupBy="start" format="Y" groupKey="year">
 *   {year -> f:format.date(format: 'Y')}
 *   <f:for each="{itemsByYear}" as="item">
 *     {item.name}
 *   </f:for>
 * </a:groupedForDateTime>
 * </code>
 *
 * Output:
 * 2011
 *   apple
 *   orange
 * 2010
 *   banana
 *
 * @license http://www.gnu.org/licenses/lgpl.html GNU Lesser General Public License, version 3 or later
 * @api
 */
class GroupedForDateTimeViewHelper extends AbstractViewHelper {

    /**
     * As this ViewHelper renders HTML, the output must not be escaped.
     *
     * @var bool
     */
    protected $escapeOutput = false;

    public function initializeArguments()
    {
        parent::initializeArguments();
        $this->registerArgument('each', 'array', '', false );
        $this->registerArgument('as', 'string', '', false);
        $this->registerArgument('groupBy', 'string', '', false);
        $this->registerArgument('groupKey', 'string', '', false);
        $this->registerArgument('format', 'string', '', false);
        $this->registerArgument('dateTimeKey', 'string', '', false);
    }
    /**
     * Iterates through elements of $each and renders child nodes
     *
     * @param array $each The array or Tx_Extbase_Persistence_ObjectStorage to iterated over
     * @param string $as The name of the iteration variable
     * @param string $groupBy Group by this property
     * @param string $groupKey The name of the variable to store the current group
     * @param string $format The format for the datetime
     * @param string $dateTimeKey The name of the variable to store the current datetime
     * @throws \TYPO3\CMS\Fluid\Core\ViewHelper\Exception
     * @return string Rendered string
     * @author Bastian Waidelich <bastian@typo3.org>
     * @author Thomas Allmer <at@delusionworld.com>
     * @api
     */
    public function render(): ?string {

        $each        = $this->arguments['each'];
        $as          = $this->arguments['as'];
        $groupBy     = $this->arguments['groupBy'];
        $groupKey    = $this->arguments['groupkey'] ?? 'groupKey';
        $format      = $this->arguments['format'];
        $dateTimeKey = $this->arguments['dateTimeKey'] ?? 'dateTimeKey';

        $output = '';

        if ($each === NULL) {
            return '';
        }

        if (is_object($each)) {
            if (!$each instanceof \Traversable) {
                throw new \TYPO3\CMS\Fluid\Core\ViewHelper\Exception('GroupedForViewHelper only supports arrays and objects implementing Traversable interface' , 1253108907);
            }
            $each = iterator_to_array($each);
        }

        $groups = $this->groupElements($each, $groupBy, $format);

        foreach ($groups['values'] as $currentGroupIndex => $group) {
            $this->templateVariableContainer->add($groupKey, $groups['keys'][$currentGroupIndex]);
            $this->templateVariableContainer->add($dateTimeKey, $groups['dateTimeKeys'][$currentGroupIndex]);
            $this->templateVariableContainer->add($as, $group);
            $output .= $this->renderChildren();
            $this->templateVariableContainer->remove($groupKey);
            $this->templateVariableContainer->remove($dateTimeKey);
            $this->templateVariableContainer->remove($as);
        }
        return $output;
    }

    /**
     * Groups the given array by the specified groupBy property and format for the datetime.
     *
     * @param array $elements The array / traversable object to be grouped
     * @param string $groupBy Group by this property
     * @param string $format The format for the datetime
     * @throws \TYPO3\CMS\Fluid\Core\ViewHelper\Exception
     * @return array The grouped array in the form array('keys' => array('key1' => [key1value], 'key2' => [key2value], ...), 'values' => array('key1' => array([key1value] => [element1]), ...), ...)
     * @author Bastian Waidelich <bastian@typo3.org>
     */
    protected function groupElements(array $elements, string $groupBy, string $format): array {
        $groups = array('keys' => array(), 'values' => array());
        foreach ($elements as $key => $value) {

            if (is_array($value)) {
                $currentGroupIndex = isset($value[$groupBy]) ? $value[$groupBy] : NULL;
            } elseif (is_object($value)) {
                $currentGroupIndex = \TYPO3\CMS\Extbase\Reflection\ObjectAccess::getPropertyPath($value, $groupBy);
            } else {
                throw new \TYPO3\CMS\Fluid\Core\ViewHelper\Exception('GroupedForViewHelper only supports multi-dimensional arrays and objects' , 1253120365);
            }

            if (strpos($format, '%') !== FALSE) {
                $locale = 'de_DE'; // Replace with your desired locale
                $formatter = new \IntlDateFormatter(
                    $locale, // Locale
                    \IntlDateFormatter::FULL, // Date type
                    \IntlDateFormatter::FULL, // Time type
                    null, // Timezone
                    null, // Calendar
                    $format // Pattern
                );

                $formatedDatetime = $formatter->format($currentGroupIndex->getTimestamp());
            } else {
                $formatedDatetime = $currentGroupIndex->format($format);
            }
            $groups['dateTimeKeys'][$formatedDatetime] = $currentGroupIndex;

            if (strpos($format, '%') !== FALSE) {
                $locale = 'de_DE'; // Replace with your desired locale
                $formatter = new \IntlDateFormatter(
                    $locale, // Locale
                    \IntlDateFormatter::FULL, // Date type
                    \IntlDateFormatter::FULL, // Time type
                    null, // Timezone
                    null, // Calendar
                    $format // Pattern
                );
                $currentGroupIndex = $formatter->format($currentGroupIndex->getTimestamp());
            } else {
                $currentGroupIndex = $currentGroupIndex->format($format);
            }

            $currentGroupKeyValue = $currentGroupIndex;
            if (is_object($currentGroupIndex)) {
                $currentGroupIndex = spl_object_hash($currentGroupIndex);
            }
            $groups['keys'][$currentGroupIndex] = $currentGroupKeyValue;
            $groups['values'][$currentGroupIndex][$key] = $value;
        }

        return $groups;
    }
}
