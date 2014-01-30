<?php
namespace PatrickBroens\Contentelements\Domain\Model;

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
 * Page content
 */
class Content extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity {

	/**
	 * The content header
	 *
	 * @var string
	 */
	protected $header = '';

	/**
	 * Header type
	 *
	 * @var string
	 */
	protected $headerLayout = '';

	/**
	 * The column the content resides in
	 *
	 * @var int
	 */
	protected $columnPosition = 0;

	/**
	 * Show in section menus
	 *
	 * @var boolean
	 */
	protected $showInSectionMenus = FALSE;

	/**
	 * Get the header
	 *
	 * @return string
	 */
	public function getHeader() {
		return $this->header;
	}

	/**
	 * Get the header layout
	 *
	 * @return string
	 */
	public function getHeaderLayout() {
		return $this->headerLayout;
	}

	/**
	 * Get the column the content resides in
	 *
	 * @return int
	 */
	public function getColumnPosition() {
		return $this->columnPosition;
	}

	/**
	 * Check if the content should be shown in section menus
	 * @return boolean
	 */
	public function showInSectionMenus() {
		return $this->showInSectionMenus;
	}
}