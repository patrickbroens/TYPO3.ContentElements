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
class ContentRepository extends AbstractRepository {

	/**
	 * Find content with 'Show in Section Menus' enabled in a page
	 *
	 * By default only content in colPos=0 will be found. This can be overruled by using $column
	 *
	 * If you set property type to "all", then the 'Show in Section Menus' checkbox is not considered
	 * and all content elements are selected.
	 *
	 * If the property $type is 'header' then only content elements with a visible header layout
	 * (and a non-empty 'header' field!) is selected.
	 * In other words, if the header layout of an element is set to 'Hidden' then the page will not appear in the menu.
	 *
	 * @param array $pageUid The page uid's
	 * @param string $type Search method
	 * @param integer $column Restrict content by the column number
	 * @return array|\TYPO3\CMS\Extbase\Persistence\QueryResultInterface
	 */
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
}