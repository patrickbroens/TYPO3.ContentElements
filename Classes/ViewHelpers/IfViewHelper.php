<?php
namespace PatrickBroens\Contentelements\ViewHelpers;

/***************************************************************
 *  Copyright notice
 *
 *  (c) 2013 Patrick Broens <patrick@patrickbroens.nl>
 *
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 3 of the License, or
 *  (at your option) any later version.
 *
 *  The GNU General Public License can be found at
 *  http://www.gnu.org/copyleft/gpl.html.
 *
 *  This script is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  This copyright notice MUST APPEAR in all copies of the script!
 ***************************************************************/

/**
 * This view helper implements an if/else condition where OR and AND conditions are possible.
 * It's an extended version on top of the default Fluid IfViewHelper
 *
 * **Conditions:**
 *
 * "or" and "and" parameters are always arrays, so you can fill it with multiple conditions
 *
 * Using only the "condition" parameter:
 * This works the same as in the default Fluid IfViewHelper.
 *
 * Using the "condition" and "or" parameter:
 * All the conditions in "or" and "condition" are evaluated with OR.
 *
 * Using the "condition" and "and" parameters:
 * All the conditions in "and" and "condition" are evaluated with AND.
 *
 * Using "condition", "and" and "or" parameters:
 * All the conditions in "and" will be evaluated with AND.
 * All the conditions in "or" will be evaluated with OR.
 * At the end the total evaluation will be:
 * (condition && and) || or
 *
 * = Examples =
 *
 * <code title="AND evaluation">
 * <ce:if condition="{page.title}" and="{0: '{page.uid} == 5', 1: '{page.doktype} != 1'}">
 *   This is being shown in case the condition matches
 * </ce:if>
 * </code>
 *
 * <output>
 * Everything inside the <ce:if> tag will be shown when
 * "the page title is not empty" AND "the page uid = 5" AND "the page doktype is 'standard'"
 * </output>
 *
 *
 * <code title="OR evaluation">
 * <ce:if condition="{page.title}" or="{0: '{page.uid} == 5', 1: '{page.doktype} != 1'}">
 *   This is being shown in case the condition matches
 * </ce:if>
 * </code>
 *
 * <output>
 * Everything inside the <ce:if> tag will be shown when
 * "the page title is not empty" OR "the page uid = 5" OR "the page doktype is 'standard'"
 * </output>
 *
 *
 * <code title="OR & AND evaluation">
 * <ce:if condition="{page.title}" and="{0: '{page.uid} == 5'}" or="{0: '{page.doktype} != 1'}">
 *   This is being shown in case the condition matches
 * </ce:if>
 * </code>
 *
 * <output>
 * Everything inside the <ce:if> tag will be shown when
 * ("the page title is not empty" AND "the page uid = 5") OR "the page doktype is 'standard'"
 * </output>
 *
 * @see \TYPO3\CMS\Fluid\ViewHelpers\IfViewHelper
 */
class IfViewHelper extends \TYPO3\CMS\Fluid\Core\ViewHelper\AbstractConditionViewHelper {

	/**
	 * Render the view helper
	 *
	 * @param boolean $condition The condition
	 * @param array $or Array with OR condition strings
	 * @param array $and Array with AND condition strings
	 * @return string
	 */
	public function render($condition, $or = array(), $and = array()) {
		$content = '';
		if (!empty($or)) {
			if (!empty($and)) {
				if (($this->isConditionValid($condition) && $this->isAndValid($and)) || $this->isOrValid($or)) {
					$content =  $this->renderThenChild();
				}
			} else {
				if ($this->isConditionValid($condition) || $this->isOrValid($or)) {
					$content =  $this->renderThenChild();
				}
			}
		} elseif (!empty($and)) {
			if ($this->isConditionValid($condition) && $this->isAndValid($and)) {
				$content =  $this->renderThenChild();
			}
		} elseif ($condition) {
			$content =  $this->renderThenChild();
		} else {
			$content = $this->renderElseChild();
		}

		return $content;
	}

	/**
	 * Evaluate the condition parameter
	 *
	 * @param $condition The condition
	 * @return bool
	 */
	protected function isConditionValid($condition) {
		if ($condition) {
			return TRUE;
		}

		return FALSE;
	}

	/**
	 * Evaluate all conditions within the "or" parameter with OR
	 *
	 * @param $conditions The conditions
	 * @return bool|null
	 */
	protected function isOrValid($conditions) {
		if (!empty($conditions)) {
			$result = FALSE;

			foreach ($conditions as $condition) {
				$rootNode = new \TYPO3\CMS\Fluid\Core\Parser\SyntaxTree\RootNode();
				$rootNode->addChildNode(new \TYPO3\CMS\Fluid\Core\Parser\SyntaxTree\TextNode($condition));

				$booleanNode = new \TYPO3\CMS\Fluid\Core\Parser\SyntaxTree\BooleanNode($rootNode);

				if ($booleanNode->evaluate($this->renderingContext)) {
					$result = TRUE;
					break;
				}
			}
		} else {
			$result = NULL;
		}

		return $result;
	}

	/**
	 * Evaluate all conditions within the "and" parameter with AND
	 *
	 * @param $conditions The conditions
	 * @return bool|null
	 */
	protected function isAndValid($conditions) {
		if (!empty($conditions)) {
			$result = TRUE;

			foreach ($conditions as $condition) {
				$rootNode = new \TYPO3\CMS\Fluid\Core\Parser\SyntaxTree\RootNode();
				$rootNode->addChildNode(new \TYPO3\CMS\Fluid\Core\Parser\SyntaxTree\TextNode($condition));

				$booleanNode = new \TYPO3\CMS\Fluid\Core\Parser\SyntaxTree\BooleanNode($rootNode);

				if (!$booleanNode->evaluate($this->renderingContext)) {
					$result = FALSE;
					break;
				}
			}
		} else {
			$result = NULL;
		}

		return $result;
	}
}