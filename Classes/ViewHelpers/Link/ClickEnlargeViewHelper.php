<?php
namespace PatrickBroens\Contentelements\ViewHelpers\Link;

/***************************************************************
 *  Copyright notice
 *
 *  (c) 2015 Patrick Broens <patrick@patrickbroens.nl>
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
 * A view helper for creating a link for an image popup.
 *
 * = Example =
 *
 * <code title="enlarge image on click">
 * <ce:link.clickEnlarge image="{image}" configuration="{settings.images.popup}"><img src=""></ce:link.clickEnlarge>
 * </code>
 *
 * <output>
 * <a href="url" onclick="javascript" target="thePicture"><img src=""></a>
 * </output>
 */

class ClickEnlargeViewHelper extends \TYPO3\CMS\Fluid\Core\ViewHelper\AbstractViewHelper {

	/**
	 * Render the view helper
	 *
	 * @param string|\TYPO3\CMS\Core\Resource\File|\TYPO3\CMS\Core\Resource\FileReference $image The original image file
	 * @param array $configuration The configuration for the popup
	 */
	public function render(
		$image,
		$configuration
	) {
		$content = $this->renderChildren();

		$configuration['enable'] = TRUE;

		return $GLOBALS['TSFE']->cObj->imageLinkWrap($content, $image, $configuration);
	}
}