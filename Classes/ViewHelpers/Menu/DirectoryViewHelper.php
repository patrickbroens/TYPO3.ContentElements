<?php
namespace PatrickBroens\Contentelements\ViewHelpers\Menu;

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

class DirectoryViewHelper extends \TYPO3\CMS\Fluid\Core\ViewHelper\AbstractViewHelper {

	/**
	 * The page repository
	 *
	 * @var \PatrickBroens\Contentelements\Domain\Repository\PageRepository
	 * @inject
	 */
	protected $pageRepository;

	/**
	 *
	 *
	 *
	 * @param string $as
	 * @param integer $pageUids
	 * @param integer $entryLevel
	 * @param string $level
	 * @param integer $maximumLevel
	 * @return string
	 * @throws \TYPO3\CMS\Fluid\Core\ViewHelper\Exception
	 * @todo Make a menu array with cur, curifsub, act, actifsub
	 * @todo Check on doktype for menu
	 * @todo Check rootline
	 * @todo Level should be in register, so it does not have to be passed
	 * @todo menuLevel can be removed then
	 * @todo Level key should be configurable, like level="fooLevel"
	 */
	public function render($as, $pageUids = NULL, $entryLevel = NULL, $level = 'level', $maximumLevel = 10) {
		// Remove empty entries from array
		$pageUids = array_filter($pageUids);

		// If no pages have been defined, use the current page
		if ($pageUids === NULL) {
			if ($entryLevel !== NULL) {
				$pageUids = array($GLOBALS['TSFE']->tmpl->rootLine[$entryLevel]['uid']);
			} else {
				$pageUids = array($GLOBALS['TSFE']->id);
			}
		}

		// Throw an exception when pageUids is not traversable
		if (is_object($pageUids) && !$pageUids instanceof \Traversable) {
			throw new \TYPO3\CMS\Fluid\Core\ViewHelper\Exception(
				'Menu/DirectoryViewHelper pageUids only supports arrays or objects implementing \Traversable interface',
				1391113811
			);
		}

		$pages = $this->pageRepository->findByPids($pageUids);

		if ($pages->count() > 0) {

			if (!$GLOBALS['TSFE']->register['ceMenuLevel']) {
				$GLOBALS['TSFE']->register['ceMenuLevel'] = 1;
				$GLOBALS['TSFE']->register['ceMenuMaximumLevel'] = $maximumLevel;
			} else {
				$GLOBALS['TSFE']->register['ceMenuLevel']++;
			}

			if ($GLOBALS['TSFE']->register['ceMenuLevel'] > $GLOBALS['TSFE']->register['ceMenuMaximumLevel']) {
				return '';
			}

			$this->templateVariableContainer->add($level, $GLOBALS['TSFE']->register['ceMenuLevel']);
			$this->templateVariableContainer->add($as, $pages);
			$output = $this->renderChildren();
			$this->templateVariableContainer->remove($as);
			$this->templateVariableContainer->remove($level);

			$GLOBALS['TSFE']->register['ceMenuLevel']--;

			if ($GLOBALS['TSFE']->register['ceMenuLevel'] === 0) {
				unset($GLOBALS['TSFE']->register['ceMenuLevel']);
				unset($GLOBALS['TSFE']->register['ceMenuMaximumLevel']);
			}
		} else {
			return '';
		}

		return $output;
	}
}