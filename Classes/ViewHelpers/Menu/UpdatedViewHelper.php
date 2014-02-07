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

/**
 * A view helper which returns recently updated subpages (multiple levels) of the given pages
 *
 * = Example =
 *
 * <code title="Pages with the similar keyword(s) of page uid = 1 and uid = 2">
 * <ce:menu.updated pageUids="{0: 1, 1: 2}" as="pages">
 *   <f:for each="{pages}" as="page">
 *     {page.title}
 *   </f:for>
 * </ce:menu.updated>
 * </code>
 *
 * <output>
 * Recently updated subpage 1
 * Recently updated subpage 2
 * Recently updated subpage 3
 * </output>
 */
class UpdatedViewHelper extends \TYPO3\CMS\Fluid\Core\ViewHelper\AbstractViewHelper {

	/**
	 * The page repository
	 *
	 * @var \PatrickBroens\Contentelements\Domain\Repository\PageRepository
	 * @inject
	 */
	protected $pageRepository;

	/**
	 * @var \TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface
	 * @inject
	 */
	protected $configurationManager;

	/**
	 * Render the view helper
	 *
	 * @param string $as The name of the iteration variable
	 * @param array $pageUids The page uids of the parent pages
	 * @param string $maximumAge The maximum age of the pages
	 * @param boolean $excludeNoSearchPages Exclude pages with field 'Exclude in search' disabled
	 * @param boolean $includeNotInMenu Should pages which are hidden for menu's be included
	 * @return string
	 */
	public function render(
		$as,
		$pageUids = array(),
		$maximumAge = '604800',
		$excludeNoSearchPages = TRUE,
		$includeNotInMenu = FALSE
	) {
		// If no pages have been defined, use the current page
		if (empty($pageUids)) {
			$pageUids = array($GLOBALS['TSFE']->page['uid']);
		}

		$contentObject = $this->configurationManager->getContentObject();

		$minimumTimeStamp = time() - intval($contentObject->calc($maximumAge));

		$unfilteredPageTreeUids = array();
		foreach ($pageUids as $pageUid) {
			$unfilteredPageTreeUids = array_merge(
				$unfilteredPageTreeUids,
				explode(
					',',
					$contentObject->getTreeList($pageUid, 20)
				)
			);
		}
		$pageTreeUids = array_unique($unfilteredPageTreeUids);

		$this->pageRepository->setIncludeNotInMenu($includeNotInMenu);

		$pages = $this->pageRepository->findByMinimumTimestamp($pageTreeUids, $minimumTimeStamp, $excludeNoSearchPages);

		$this->templateVariableContainer->add($as, $pages);
		$output = $this->renderChildren();
		$this->templateVariableContainer->remove($as);

		return $output;
	}
}