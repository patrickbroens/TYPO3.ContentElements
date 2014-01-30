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

class Transform {
	public function linesToArray($input) {
		$rows = \TYPO3\CMS\Core\Utility\GeneralUtility::trimExplode(LF, $input);

		return $rows;
	}

	public function CsvToArray($input, $delimiter = ',', $enclosure = '"', $columns = 0) {
		$multiArray = array();
		$maximumCellCount = 0;

		$rows = \TYPO3\CMS\Core\Utility\GeneralUtility::trimExplode(LF, $input);

		foreach ($rows as $row) {
			$cells = str_getcsv($row, $delimiter, $enclosure);

			if (count($cells) > $maximumCellCount) {
				$maximumCellCount = count($cells);
			}

			$multiArray[] = $cells;
		}

		if ($columns > $maximumCellCount) {
			$maximumCellCount = $columns;
		}

		foreach ($multiArray as &$row) {
			for ($key = 0; $key <= ($maximumCellCount - 1); $key++) {
				if ($columns > 0 && $columns < $maximumCellCount && $key >= $columns) {
					if (array_key_exists($key, $row)) {
						unset($row[$key]);
					}
				} else {
					if (!array_key_exists($key, $row)) {
						$row[$key] = '';
					}
				}
			}
		}

		return $multiArray;
	}
}