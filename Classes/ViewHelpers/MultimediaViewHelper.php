<?php
namespace PatrickBroens\Contentelements\ViewHelpers;

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
 * A view helper which returns the TypoScript cObj MULTIMEDIA
 *
 * = Example =
 *
 * <code title="Example">
 * <ce:multimedia file="uploads/media/{data.multimedia}" parameters="{data.bodytext}" />
 * </code>
 *
 * <output>
 * <img src="path/to/image/1" width="365" height="200" />
 * <img src="path/to/image/2" width="365" height="250" />
 * <img src="path/to/image/3" width="365" height="200" />
 * </output>
 */
class MultimediaViewHelper extends \TYPO3\CMS\Fluid\Core\ViewHelper\AbstractViewHelper {

	/**
	 * Render the TypoScript Object MULTIMEDIA
	 *
	 * @param $file The multimedia file
	 * @param integer $width Preferred width
	 * @param integer $height Preferred height
	 * @param string $parameters Extra parameters
	 * @return mixed
	 */
	public function render($file, $width = NULL, $height = NULL, $parameters = NULL) {

			$multimediaConfiguration = array(
				'file' => $file,
				'width' => $width,
				'height' => $height,
				'params' => $parameters
			);

			return $GLOBALS['TSFE']->cObj->MULTIMEDIA($multimediaConfiguration);
	    }
}
