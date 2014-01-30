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
 * A page
 */
class Page extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity {

	/**
	 * The page title
	 *
	 * @var string
	 */
	protected $title;

	/**
	 * The page navigation title
	 *
	 * @var string
	 */
	protected $navigationTitle;

	/**
	 * The page subtitle
	 *
	 * @var string
	 */
	protected $subtitle;

	/**
	 * The page abstract
	 *
	 * @var string
	 */
	protected $abstract;

	/**
	 * The keywords of the page
	 *
	 * @var string
	 */
	protected $keywords;

	/**
	 * The page description
	 *
	 * @var string
	 */
	protected $description;

	/**
	 * The page language overlay
	 *
	 * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\PatrickBroens\Contentelements\Domain\Model\PageLanguageOverlay>
	 * @lazy
	 */
	protected $overlay;

	/**
	 * The categories of the page
	 *
	 * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\TYPO3\CMS\Extbase\Domain\Model\Category>
	 * @lazy
	 */
	protected $categories;

	/**
	 * The page content
	 *
	 * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\PatrickBroens\Contentelements\Domain\Model\Content>
	 * @lazy
	 */
	protected $content;

	/**
	 * @return mixed
	 */
	public function getTitle() {
		return $this->title;
	}

	/**
	 * @return mixed
	 */
	public function getNavTitle() {
		return $this->navTitle;
	}

	/**
	 * @return mixed
	 */
	public function getSubtitle() {
		return $this->subtitle;
	}

	/**
	 * @return mixed
	 */
	public function getAbstract() {
		return $this->abstract;
	}

	/**
	 * @return mixed
	 */
	public function getKeywords() {
		return $this->keywords;
	}

	/**
	 * @return mixed
	 */
	public function getDescription() {
		return $this->description;
	}
}