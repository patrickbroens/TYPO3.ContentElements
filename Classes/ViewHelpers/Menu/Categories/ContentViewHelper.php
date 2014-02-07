<?php
namespace PatrickBroens\Contentelements\ViewHelpers\Menu\Categories;

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
 * A view helper which returns content elements with assigned categories
 *
 * = Example =
 *
 * <code title="Content elements with categories 1 and 2 assigned">
 * <ce:menu.categories.content categoryUids="{0: 1, 1: 2}" as="contentElements" relationField="category_field">
 *   <f:for each="{contentElements}" as="contentElement">
 *     {contentElement.header}
 *   </f:for>
 * </ce:menu.categories.content>
 * </code>
 *
 * <output>
 * Content element with category 1 assigned
 * Content element with category 1 and 2 assigned
 * </output>
 */
class ContentViewHelper extends \TYPO3\CMS\Fluid\Core\ViewHelper\AbstractViewHelper {

	/**
	 * The content repository
	 *
	 * @var \PatrickBroens\Contentelements\Domain\Repository\ContentRepository
	 * @inject
	 */
	protected $contentRepository;

	/**
	 * Render the view helper
	 *
	 * @param array $categoryUids The categories assigned to the content elements
	 * @param string $as The name of the iteration variable
	 * @param string $relationField The category field for MM relation table
	 * @return string
	 */
	public function render($categoryUids, $as, $relationField) {
		if (empty($categoryUids)) {
			return '';
		}

		$contentElements = $this->contentRepository->findByCategories($categoryUids, $relationField, 'tt_content');

		$this->templateVariableContainer->add($as, $contentElements);
		$output = $this->renderChildren();
		$this->templateVariableContainer->remove($as);

		return $output;
	}
}