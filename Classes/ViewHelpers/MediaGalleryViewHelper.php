<?php
namespace PatrickBroens\Contentelements\ViewHelpers;

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
 * A view helper which returns a media gallery
 *
 * The media gallery will be returned as a multidimensional array:
 *
 * $gallery
 *   [count]
 *     [files] The amount of media in the gallery
 *     [columns] The amount of columns the gallery is using
 *     [rows] The amount of rows the gallery is using
 *   [rows]
 *     [<rowNumber>]
 *       [columns]
 *         [<columnNumber>]
 *           [media] The media object
 *           [dimensions]
 *             [width] Calculated width for the media in the gallery
 *             [height] Calculated height for the media in the gallery
 *
 * = Example =
 *
 * <code title="Example">
 * <ce:mediaGallery references="{data.media}" width="740" as="gallery" columns="2" columnSpacing="10">
 *   <f:for each="{gallery.rows}" as="row">
 *     <f:for each="{row.columns}" as="column">
 *       <f:image image="{column.media}" width="{column.dimensions.width}" height="{column.dimensions.height}" />
 *     </f:for>
 *   </f:for>
 * </ce:mediaGallery>
 * </code>
 *
 * <output>
 * <img src="path/to/media/1" width="365" height="200" />
 * <img src="path/to/media/2" width="365" height="250" />
 * <iframe src="path/to/externalmedia/3" width="365" height="200">...</iframe>
 * </output>
 */
class MediaGalleryViewHelper extends \TYPO3\CMS\Fluid\Core\ViewHelper\AbstractViewHelper {

	/**
	 * The file objects
	 *
	 * @var array
	 */
	protected $fileObjects = array();

	/**
	 * The amount of files
	 *
	 * @var int
	 */
	protected $fileCount = 0;

	/**
	 * The amount of rows
	 *
	 * @var int
	 */
	protected $rows = 0;

	/**
	 * The amount of columns
	 *
	 * @var int
	 */
	protected $columns = 0;

	/**
	 * The dimensions of each media element
	 *
	 * @var array
	 */
	protected $mediaDimensions = array();

	/**
	 * The defined width of the gallery
	 *
	 * @var int
	 */
	protected $definedWidth = 0;

	/**
	 * The calculated width of the gallery
	 *
	 * @var int
	 */
	protected $calculatedWidth = 0;

	/**
	 * TRUE when a border is used for the media elements in the gallery
	 *
	 * @var boolean
	 */
	protected $borderInUse = FALSE;

	/**
	 * Render the view
	 *
	 * @param string $as The name of the iteration variable
	 * @param integer $width The width of the gallery
	 * @param array $references The file objects
	 * @param integer $columns Amount of columns
	 * @param integer $columnSpacing Spacing between the columns
	 * @param integer $rows Amount of rows
	 * @param integer $mediaHeight Predefined height of the media element
	 * @param integer $mediaWidth Predefined width of the media element
	 * @param boolean $border TRUE when border in use
	 * @param integer $borderWidth Width of the border
	 * @param integer $borderPadding Padding between border and media element
	 */
	public function render(
		$as,
		$width = 0,
		$references,
		$columns = 1,
		$columnSpacing = 0,
		$rows = 0,
		$mediaHeight = 0,
		$mediaWidth = 0,
		$border = FALSE,
		$borderWidth = 1,
		$borderPadding = 0
	) {
		$this->fileObjects = $references;
		$this->fileCount = count($this->fileObjects);

		$this->calculateRowsAndColumns($columns, $rows);

		$this->calculateMediaWidthsAndHeights(
			$width,
			$mediaHeight,
			$mediaWidth,
			$columnSpacing,
			$border,
			$borderWidth,
			$borderPadding
		);

		$gallery = $this->prepareGallery();

		$this->templateVariableContainer->add($as, $gallery);
		$output = $this->renderChildren();
		$this->templateVariableContainer->remove($as);

		return $output;
	}

	/**
	 * Calculate the rows and columns
	 *
	 * @param integer $columnAmount The amount of columns
	 * @param integer $rowAmount The amount of rows
	 * @return void
	 */
	protected function calculateRowsAndColumns($columnAmount = 1, $rowAmount = 0) {

			// If no columns defined, set it to 1
		$columns = (integer) $columnAmount > 1 ? (integer) $columnAmount : 1;

			// When more columns than media elements, set the columns to the amount of media elements
		if ($columns > $this->fileCount) {
			$columns = $this->fileCount;
		}

		if ($columns === 0) {
			$columns = 1;
		}

			// Calculate the rows from the amount of files and the columns
		$rows = ceil($this->fileCount / $columns);

			// Get the amount of rows from input
		$rowsDefined = intval($rowAmount);

			// If the rows are defined in input, the columns need to be recalculated
		if ($rowsDefined > 1) {
			$rows = $rowsDefined;
			if ($rows > $this->fileCount) {
				$rows = $this->fileCount;
			}
			if ($rows > 1) {
				$columns = ceil($this->fileCount / $rows);
			} else {
				$columns = $this->fileCount;
			}
		}

		$this->columns = $columns;
		$this->rows = $rows;
	}

	/**
	 * Calculate the width/height of the media elements
	 *
	 * Based on the width of the gallery, defined equal width or height by a user, the spacing between columns and
	 * the use of a border, defined by user, where the border width and padding are taken into account
	 *
	 * @param integer $width The width of the gallery
	 * @param integer $equalMediaHeight Predefined height of the images
	 * @param integer $equalImageWidth Predefined width of the images
	 * @param integer $columnSpacing Spacing between the columns
	 * @param boolean $border TRUE when border in use
	 * @param integer $borderWidth Width of the border
	 * @param integer $borderPadding Padding between border and image
	 * @return void
	 */
	protected function calculateMediaWidthsAndHeights(
		$width,
		$equalMediaHeight,
		$equalMediaWidth,
		$columnSpacing,
		$border,
		$borderWidth,
		$borderPadding
	) {
		$galleryWidth = $this->definedWidth = intval($width);

		$this->borderInUse = (boolean) $border;

		$columnSpacingTotal = ($this->columns - 1) * $columnSpacing;

		$galleryWidthMinusBorderAndSpacing = $galleryWidth - $columnSpacingTotal;

		if ($this->borderInUse) {
			$borderPaddingTotal = ($this->columns * 2) * $borderPadding;
			$borderWidthTotal = ($this->columns * 2) * $borderWidth;
			$galleryWidthMinusBorderAndSpacing = $galleryWidthMinusBorderAndSpacing - $borderPaddingTotal - $borderWidthTotal;
		}

			// User entered a predefined height
		if ($equalMediaHeight) {
			$mediaScalingCorrection = 1;
			$maximumRowWidth = 0;

				// Calculate the scaling correction when the total of media elements is wider than the gallery width
			for ($row = 1; $row <= $this->rows; $row++) {
				$totalRowWidth = 0;
				for ($column = 1; $column <= $this->columns; $column++) {
					$fileKey = (($row - 1) * $this->columns) + $column - 1;
					if ($fileKey > $this->fileCount - 1) {
						break 2;
					}
					$currentMediaScaling = $equalMediaHeight / $this->fileObjects[$fileKey]->getProperty('height');
					$totalRowWidth += $this->fileObjects[$fileKey]->getProperty('width') * $currentMediaScaling;
				}
				$maximumRowWidth = max($totalRowWidth, $maximumRowWidth);
				$mediaInRowScaling = $totalRowWidth / $galleryWidthMinusBorderAndSpacing;
				$mediaScalingCorrection = max($mediaInRowScaling, $mediaScalingCorrection);
			}

				// Set the corrected dimensions for each media element
			foreach ($this->fileObjects as $key => $fileObject) {
				$mediaHeight = floor($equalMediaHeight / $mediaScalingCorrection);
				$mediaWidth = floor(
					$fileObject->getProperty('width') * ($mediaHeight / $fileObject->getProperty('height'))
				);
				$this->mediaDimensions[$key] = array(
					'width' => 	$mediaWidth,
					'height' => $mediaHeight
				);
			}

			$this->calculatedWidth = floor($maximumRowWidth / $mediaScalingCorrection) + $galleryWidthMinusBorderAndSpacing;

			// User entered a predefined width
		} elseif ($equalMediaWidth) {
			$mediaScalingCorrection = 1;

				// Calculate the scaling correction when the total of media elements is wider than the gallery width
			$totalRowWidth = $this->columns * $equalMediaWidth;
			$mediaInRowScaling = $totalRowWidth / $galleryWidthMinusBorderAndSpacing;
			$mediaScalingCorrection = max($mediaInRowScaling, $mediaScalingCorrection);

				// Set the corrected dimensions for each media element
			foreach ($this->fileObjects as $key => $fileObject) {
				$mediaWidth = floor($equalMediaWidth / $mediaScalingCorrection);
				$mediaHeight = floor(
					$fileObject->getProperty('height') * ($mediaWidth / $fileObject->getProperty('width'))
				);
				$this->mediaDimensions[$key] = array(
					'width' => 	$mediaWidth,
					'height' => $mediaHeight
				);
			}

			$this->calculatedWidth = floor($totalRowWidth / $mediaScalingCorrection) + $galleryWidthMinusBorderAndSpacing;

			// Automatic setting of width and height
		} else {
			$mediaWidth = intval($galleryWidthMinusBorderAndSpacing / $this->columns);

			foreach ($this->fileObjects as $key => $fileObject) {
				if($mediaWidth > $fileObject->getProperty('width')){
					$mediaWidth = $fileObject->getProperty('width');
				}
				$mediaHeight = floor(
					$fileObject->getProperty('height') * ($mediaWidth / $fileObject->getProperty('width'))
				);
				$this->mediaDimensions[$key] = array(
					'width' => 	$mediaWidth,
					'height' => $mediaHeight
				);
			}

			$this->calculatedWidth =  $galleryWidth;
		}
	}

	/**
	 * Prepare the gallery
	 *
	 * Make an array for rows and columns
	 *
	 * @return array
	 */
	protected function prepareGallery() {
		$gallery = array(
			'count' => array(
				'files' => $this->fileCount,
				'columns' => $this->columns,
				'rows' => $this->rows
			),
			'rows' => array()
		);

		for ($row = 1; $row <= $this->rows; $row++) {

			for ($column = 1; $column <= $this->columns; $column++) {

				$fileKey = (($row - 1) * $this->columns) + $column - 1;

				$gallery['rows'][$row]['columns'][$column] = array(
					'media' => $this->fileObjects[$fileKey],
					'dimensions' => array(
						'width' => $this->mediaDimensions[$fileKey]['width'],
						'height' => $this->mediaDimensions[$fileKey]['height']
					)
				);
			}
		}

		return $gallery;
	}
}