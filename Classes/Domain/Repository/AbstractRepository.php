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
 * Abstract for repositories
 */
class AbstractRepository extends \TYPO3\CMS\Extbase\Persistence\Repository {

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

	/**
	 * Find records from a certain table which have categories assigned
	 *
	 * @param $categoryUids The uids of the categories
	 * @param $relationField Field relation in MM table
	 * @return array
	 */
	public function findByCategories($categoryUids, $relationField, $tableName = 'pages') {
		$result = array();

		foreach ($categoryUids as $categoryUid) {
			try {
				$collection = \TYPO3\CMS\Frontend\Category\Collection\CategoryCollection::load(
					$categoryUid,
					TRUE,
					$tableName,
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