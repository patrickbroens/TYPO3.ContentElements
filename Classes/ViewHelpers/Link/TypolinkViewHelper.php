<?php
namespace PatrickBroens\Contentelements\ViewHelpers\Link;

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
 * A view helper for creating links to TYPO3 pages using Typolink notation.
 *
 * = Example =
 *
 * <code title="link to the current page">
 * <ce:link.typolink parameter="123">page link</ce:link.typolink>
 * </code>
 *
 * <output>
 * <a href="index.php?id=123">page link</a>
 * </output>
 */

class TypolinkViewHelper extends \TYPO3\CMS\Fluid\Core\ViewHelper\AbstractViewHelper {

	/**
	 * Render the view helper
	 *
	 * @param string $parameter This is the main data that is used for creating the link
	 * @param string $target Target used for internal links
	 * @param int $noCache Adds a "&no_cache=1"-parameter to the link
	 * @param int $useCacheHash If set, the additionalParams list is exploded and calculated into a hash string appended to the URL
	 * @param array $additionalParams Parameters that are added to the end of the URL
	 * @param string $ATagParams Additional attributes for the anchor <a> tag, like class="foo"
	 * @param string $extTarget Target used for external links
	 * @return mixed
	 * @see http://docs.typo3.org/typo3cms/TyposcriptReference/Functions/Typolink/Index.html
	 * @todo Add more functionality of Typolink
	 */
	public function render(
		$parameter,
		$target = '',
		$noCache = 0,
		$useCacheHash = 1,
		$additionalParams = array(),
		$ATagParams = '',
		$extTarget = ''
	) {

		$typoLinkConfiguration = array(
			'parameter' => $parameter,
		);

		if ($target) {
			$typoLinkConfiguration['target'] = $target;
		}

		if ($target) {
			$typoLinkConfiguration['extTarget'] = $extTarget;
		}

		if ($noCache) {
			$typoLinkConfiguration['no_cache'] = 1;
		}

		if ($useCacheHash) {
			$typoLinkConfiguration['useCacheHash'] = 1;
		}

		if (count($additionalParams)) {
			$typoLinkConfiguration['additionalParams'] = \TYPO3\CMS\Core\Utility\GeneralUtility::implodeArrayForUrl(
				'',
				$additionalParams
			);
		}

		if (strlen($ATagParams)) {
			$typoLinkConfiguration['ATagParams'] = $ATagParams;
		}

		$linkText = $this->renderChildren();

		$textContentConfiguration = array(
			'typolink.' => $typoLinkConfiguration,
			'value' => $linkText
		);

		return $GLOBALS['TSFE']->cObj->cObjGetSingle('TEXT', $textContentConfiguration);
	}
}