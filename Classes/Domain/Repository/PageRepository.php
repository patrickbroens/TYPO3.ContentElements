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
	 * Find pages by uid's
	 *
	 * @param array $pageUids The page uid's
	 * @return array|\TYPO3\CMS\Extbase\Persistence\QueryResultInterface
	 */
	public function findByUids($pageUids) {
		$query = $this->createQuery();

		$query->matching(
			$query->in('uid', $pageUids)
		);

		return $query->execute();
	}

	/**
	 * Find subpages
	 *
	 * @param array $pageUids The parent page uid's
	 * @return array|\TYPO3\CMS\Extbase\Persistence\QueryResultInterface
	 */
	public function findByPids($pageUids) {
		$query = $this->createQuery();

		$query->matching(
			$query->in('pid', $pageUids)
		);

		return $query->execute();
	}

	/**
	 * Find pages with a minimum timestamp
	 *
	 * @param array $pageUids The page uid's
	 * @param integer $minimumTimeStamp The minimum unix timestamp
	 * @param boolean $excludeNoSearchPages Exclude pages with 'Include in Search' disabled
	 * @return array|\TYPO3\CMS\Extbase\Persistence\QueryResultInterface
	 */
	public function findByMinimumTimestamp($pageUids, $minimumTimeStamp, $excludeNoSearchPages = TRUE) {
		$query = $this->createQuery();

		$constraints = array(
			$query->in('uid', $pageUids),
			$query->greaterThanOrEqual('tstamp', $minimumTimeStamp)
		);

		if ($excludeNoSearchPages) {
			$constraints[] = $query->equals('no_search', 0);
		} else {
			$constraints[] = $query->equals('no_search', 1);
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
	 * @param array $pageUids The page uid's
	 * @param array $keywords The keywords to search for
	 * @param boolean $excludeNoSearchPages Exclude pages with 'Include in Search' disabled
	 * @return array|\TYPO3\CMS\Extbase\Persistence\QueryResultInterface
	 */
	public function findByKeywords($pageUids, $keywords, $excludeNoSearchPages = TRUE) {
		$query = $this->createQuery();

		$constraints = array(
			$query->in('uid', $pageUids)
		);

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
}