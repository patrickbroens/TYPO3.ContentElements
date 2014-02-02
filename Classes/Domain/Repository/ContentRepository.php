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
 * A repository for content
 */
class ContentRepository extends \TYPO3\CMS\Extbase\Persistence\Repository {

	/**
	 * Initialize repository
	 *
	 * @return void
	 */
	public function initializeObject() {
		$defaultQuerySettings = $this->objectManager->get('TYPO3\\CMS\\Extbase\\Persistence\\Generic\\Typo3QuerySettings');
		$defaultQuerySettings->setRespectStoragePage(FALSE);

		$this->setDefaultQuerySettings($defaultQuerySettings);
	}

	public function findBySection($pageUid, $type = '', $column = 0) {
		$query = $this->createQuery();

		$constraints = array(
			$query->equals('pid', $pageUid),
			$query->equals('columnPosition', $column)
		);

		switch($type) {
			case 'all':
				break;
			case 'header':
				$constraints[] = $query->equals('showInSectionMenus', 1);
				$constraints[] = $query->logicalNot(
					$query->equals('header', '')
				);
				$constraints[] = $query->logicalNot(
					$query->equals('headerLayout', 100)
				);
				break;
			default:
				$constraints[] = $query->equals('showInSectionMenus', 1);
		}

		$query->matching(
			$query->logicalAnd(
				$constraints
			)
		);

		return $query->execute();
	}

	/**
	 * @param $categoryUids
	 * @param $relationField
	 * @return array
	 * @todo Bring to abstract, since the content repository is using the same. Only difference is table name
	 */
	public function findByCategories($categoryUids, $relationField) {
		$result = array();

		foreach ($categoryUids as $categoryUid) {
			try {
				$collection = \TYPO3\CMS\Frontend\Category\Collection\CategoryCollection::load(
					$categoryUid,
					TRUE,
					'tt_content',
					$relationField
				);
				if ($collection->count() > 0) {
					foreach ($collection as $record) {
						$result[$record['uid']] = $record;
					}
				}
			} catch (\Exception $e) {

			}
		}

		return $result;
	}
}