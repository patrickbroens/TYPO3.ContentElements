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
 * A view helper which returns content elements with 'Show in Section Menus' enabled
 *
 * By default only content in colPos=0 will be found. This can be overruled by using "column"
 *
 * If you set property "type" to 'all', then the 'Show in Section Menus' checkbox is not considered
 * and all content elements are selected.
 *
 * If the property "type" is 'header' then only content elements with a visible header layout
 * (and a non-empty 'header' field!) are selected.
 * In other words, if the header layout of an element is set to 'Hidden' then the element will not be in the results.
 *
 * = Example =
 *
 * <code title="Content elements in page with uid = 1 and 'Show in Section Menu's' enabled">
 * <ce:menu.section pageUid="1" as="contentElements">
 *   <f:for each="{contentElements}" as="contentElement">
 *     {contentElement.header}
 *   </f:for>
 * </ce:menu.section>
 * </code>
 *
 * <output>
 * Content element 1 in page with uid = 1 and "Show in section menu's" enabled
 * Content element 2 in page with uid = 1 and "Show in section menu's" enabled
 * Content element 3 in page with uid = 1 and "Show in section menu's" enabled
 * </output>
 */
class SectionViewHelper extends \TYPO3\CMS\Fluid\Core\ViewHelper\AbstractViewHelper {

	/**
	 * The content repository
	 *
	 * @var \PatrickBroens\Contentelements\Domain\Repository\ContentRepository
	 * @inject
	 */
	protected $contentRepository;

	/**
	 * @var \TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface
	 * @inject
	 */
	protected $configurationManager;

	/**
	 * Render the view helper
	 *
	 * @param string $as The name of the iteration variable
	 * @param integer $pageUid The page
	 * @param string $type Search method
	 * @param integer $column Restrict content by the column number
	 * @return string
	 */
	public function render($as, $pageUid = NULL, $type = '', $column = 0) {
		if (empty($pageUid)) {
			$pageUid = $GLOBALS['TSFE']->id;
		}

		if (!empty($type) && !in_array($type, array('all', 'header'))) {
			return '';
		}

		$pages = $this->contentRepository->findBySection($pageUid, $type, $column);

		$this->templateVariableContainer->add($as, $pages);
		$output = $this->renderChildren();
		$this->templateVariableContainer->remove($as);

		return $output;
	}
}