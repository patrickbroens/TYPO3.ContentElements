<?php
namespace PatrickBroens\Contentelements\Domain\Repository;

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
 * A repository for pages
 */
class PageRepository extends AbstractRepository {

	/**
	 * Whether to include pages where nav_hide is set
	 *
	 * @var bool
	 */
	protected $includeNotInMenu = FALSE;

	/**
	 * Whether to include pages of doktype = 199
	 *
	 * @var bool
	 */
	protected $includeMenuSeparator = FALSE;

	/**
	 * Find pages by uid's
	 *
	 * @param array $pageUids The page uid's
	 * @return array|\TYPO3\CMS\Extbase\Persistence\QueryResultInterface
	 */
	public function findByUids($pageUids) {
		$query = $this->createQuery();

		$constraints = $this->setPageTypeConstraints($query);
		$constraints[] = $query->in('uid', $pageUids);

		$query->matching(
			$query->logicalAnd(
				$constraints
			)
		);

		return $query->execute();
	}

	/**
	 * Find subpages by pid
	 *
	 * @param array $pageUids The parent page uid's
	 * @return array|\TYPO3\CMS\Extbase\Persistence\QueryResultInterface
	 */
	public function findByPids($pageUids) {
		$query = $this->createQuery();

		$constraints = $this->setPageTypeConstraints($query);
		$constraints[] = $query->in('pid', $pageUids);

		$query->matching(
			$query->logicalAnd(
				$constraints
			)
		);

		return $query->execute();
	}

	/**
	 * Find pages with a minimum timestamp
	 *
	 * Pages with the field "Include in search" set to disabled can be excluded from the result.
	 *
	 * @param array $pageUids The page uid's
	 * @param integer $minimumTimeStamp The minimum unix timestamp
	 * @param boolean $excludeNoSearchPages Exclude pages with 'Include in Search' disabled
	 * @return array|\TYPO3\CMS\Extbase\Persistence\QueryResultInterface
	 */
	public function findByMinimumTimestamp($pageUids, $minimumTimeStamp, $excludeNoSearchPages = TRUE) {
		$query = $this->createQuery();

		$constraints = $this->setPageTypeConstraints($query);
		$constraints[] = $query->in('uid', $pageUids);
		$constraints[] = $query->greaterThanOrEqual('tstamp', $minimumTimeStamp);

		if ($excludeNoSearchPages) {
			$constraints[] = $query->equals('no_search', 0);
		}

		$query->matching(
			$query->logicalAnd(
				$constraints
			)
		);

		return $query->execute();
	}

	/**
	 * Find pages which have keywords
	 *
	 * Pages with the field "Include in search" set to disabled can be excluded from the result.
	 *
	 * @param array $pageUids The page uid's
	 * @param array $keywords The keywords to search for
	 * @param boolean $excludeNoSearchPages Exclude pages with 'Include in Search' disabled
	 * @return array|\TYPO3\CMS\Extbase\Persistence\QueryResultInterface
	 */
	public function findByKeywords($pageUids, $keywords, $excludeNoSearchPages = TRUE) {
		$query = $this->createQuery();

		$constraints = $this->setPageTypeConstraints($query);
		$constraints[] = $query->in('uid', $pageUids);

		if ($excludeNoSearchPages) {
			$constraints[] = $query->equals('no_search', 0);
		} else {
			$constraints[] = $query->equals('no_search', 1);
		}

		$keywordConstraints = array();
		foreach($keywords as $keyword) {
			$keywordConstraints[] = $query->like('keywords', '%' . $keyword . '%');
		}

		$constraints[] = $query->logicalOr(
			$keywordConstraints
		);



		$query->matching(
			$query->logicalAnd(
				$constraints
			)
		);

		return $query->execute();
	}

	/**
	 * Set the constraints for the page doktype and field "nav_hide"
	 *
	 * By default the following doktypes are always ignored:
	 * - 6: Backend User Section
	 * - > 200: Folder (254)
	 *          Recycler (255)
	 *
	 * Optional are:
	 * - 199: Menu separator
	 * - nav_hide: Not in menu
	 *
	 * @param array|\TYPO3\CMS\Extbase\Persistence\Generic\Query $query
	 * @return array|\TYPO3\CMS\Extbase\Persistence\Generic\Query
	 */
	protected function setPageTypeConstraints($query) {
		$constraints = array(
			$query->lessThan('doktype', 200),
		);

		$constraints[] = $query->logicalNot(
			$query->equals('doktype', 6)
		);

		if (!$this->includeMenuSeparator) {
			$constraints[] = $query->logicalNot(
				$query->equals('doktype', 199)
			);
		}

		if (!$this->includeNotInMenu) {
			$constraints[] = $query->logicalNot(
				$query->equals('nav_hide', 1)
			);
		}

		return $constraints;
	}

	/**
	 * Define whether pages which have "Include not in menu (nav_hide)" enabled will be included in the results
	 *
	 * If TRUE, pages with nav_hide = 1 will be included.
	 *
	 * @param bool $enable Enabled or disabled
	 * @return void
	 */
	public function setIncludeNotInMenu($enable = TRUE) {
		$this->includeNotInMenu = $enable;
	}

	/**
	 * Define whether pages of doktype "Menu separator (199)" will be included in the results
	 *
	 * If TRUE, pages of type "Menu separator" will be included
	 *
	 * @param bool $enable Enabled or disabled
	 * @return void
	 */
	public function setIncludeMenuSeparator($enable = TRUE) {
		$this->includeMenuSeparator = $enable;
	}
}