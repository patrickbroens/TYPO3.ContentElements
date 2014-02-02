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
	 *
	 *
	 * @param array $pageUids
	 * @param string $as
	 * @param string $maximumAge
	 * @param boolean $excludeNoSearchPages
	 * @return string
	 * @throws \TYPO3\CMS\Fluid\Core\ViewHelper\Exception
	 * @todo Implement more functionality like in tslib_menu->makeMenu()
	 */
	public function render($pageUids, $as, $maximumAge = '604800', $excludeNoSearchPages = TRUE) {
		if ($pageUids === NULL) {
			return '';
		}
		if (is_object($pageUids) && !$pageUids instanceof \Traversable) {
			throw new \TYPO3\CMS\Fluid\Core\ViewHelper\Exception(
				'Menu/UpdatedViewHelper pageUids only supports arrays or objects implementing \Traversable interface',
				1391113811
			);
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

		$pages = $this->pageRepository->findByMinimumTimestamp($pageTreeUids, $minimumTimeStamp, $excludeNoSearchPages);

		$this->templateVariableContainer->add($as, $pages);
		$output = $this->renderChildren();
		$this->templateVariableContainer->remove($as);

		return $output;
	}
}