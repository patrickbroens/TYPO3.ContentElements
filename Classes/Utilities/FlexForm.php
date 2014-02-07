<?php
namespace PatrickBroens\Contentelements\Utilities;

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

/*
 * This class should not be here. The FlexForm values should be moved to regular table columns in tt_content
 */
class FlexForm {

	/**
	 * Return value from somewhere inside a FlexForm structure
	 *
	 * @param array $flexForm FlexForm data
	 * @param string $fieldName Field name to extract. Can be given like "test/el/2/test/el/field_templateObject" where each part will dig a level deeper in the FlexForm data.
	 * @param string $sheet Sheet pointer, eg. "sDEF
	 * @param string $language Language pointer, eg. "lDEF
	 * @param string $value Value pointer, eg. "vDEF
	 * @return string The content.
	 */
	public function getFlexFormValue($flexForm, $fieldName, $sheet = 'sDEF', $language = 'lDEF', $value = 'vDEF') {
		$sheet = is_array($flexForm) ? $flexForm['data'][$sheet][$language] : '';
		if (is_array($sheet)) {
			return self::getFlexFormValueFromSheet($sheet, explode('/', $fieldName), $value);
		}
	}

	/**
	 * Returns part of $sheetArray pointed to by the keys in $fieldNameArray
	 *
	 * @param array $sheet Multidimensiona array, typically FlexForm contents
	 * @param array $fieldNames Array where each value points to a key in the FlexForms content - the input array will have the value returned pointed to by these keys. All integer keys will not take their integer counterparts, but rather traverse the current position in the array an return element number X (whether this is right behavior is not settled yet...)
	 * @param string $value Value for outermost key, typ. "vDEF" depending on language.
	 * @return mixed The value, typ. string.
	 * @see pi_getFFvalue()
	 */
	protected function getFlexFormValueFromSheet($sheet, $fieldNames, $key) {
		$temporarySheet = $sheet;

		foreach ($fieldNames as $value) {
			if (\TYPO3\CMS\Core\Utility\MathUtility::canBeInterpretedAsInteger($value)) {
				if (is_array($temporarySheet)) {
					$counter = 0;
					foreach ($temporarySheet as $values) {
						if ($counter == $value) {
							$temporarySheet = $values;
							break;
						}
						$counter++;
					}
				}
			} else {
				$temporarySheet = $temporarySheet[$value];
			}
		}

		return $temporarySheet[$key];
	}
}