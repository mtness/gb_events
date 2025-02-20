<?php
namespace In2code\GbEvents\ViewHelpers;

use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractConditionViewHelper;

/**
 * Or Viewhelper
 *
 *
 * Example
 * ----------
 * <vh:extendedIf condition="{logoIterator.isFirst}" or="{logoIterator.cycle} % 4">
 *   <f:then>Do something</f:then>
 *   <f:else>Do something else</f:else>
 * </vh:extendedIf>
 *
 */

class ExtendedIfViewHelper extends AbstractConditionViewHelper {

    /**
     * As this ViewHelper renders HTML, the output must not be escaped.
     *
     * @var bool
     */
    protected $escapeOutput = false;

    /**
     * renders <f:then> child if $condition or $or is true, otherwise renders <f:else> child.
     *
     * @param boolean $condition View helper condition
     * @param boolean $or View helper condition
     * @return string the rendered string
     */
    public function render(): ?string {

        $condition = $this->arguments['condition'];
        $or        = $this->arguments['or'];

        if ($condition || $or) {
            return $this->renderThenChild();
        } else {
            return $this->renderElseChild();
        }
    }
}
