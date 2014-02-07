<?php
namespace PatrickBroens\Contentelements\Controller;

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

use PatrickBroens\Contentelements\Utilities\FlexForm;
use TYPO3\CMS\Core\Utility\GeneralUtility;

class ContentElementController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController {

	/**
	 * The content object
	 *
	 * @var \TYPO3\CMS\Frontend\ContentObject\ContentObjectRenderer
	 */
	protected $contentObject;

	/**
	 * The object data
	 *
	 * @var mixed
	 */
	protected $data;

	/**
	 * A file collection
	 *
	 * @var \PatrickBroens\Contentelements\Resource\Collection\FileCollection
	 * @inject
	 */
	protected $fileCollection;

	/**
	 * Initialization of all actions
	 *
	 * @return void
	 */
	public function initializeAction() {
		$this->contentObject = $this->configurationManager->getContentObject();
		$this->data = $this->contentObject->data;
	}

	/**
	 * Default action, forward on field "CType"
	 *
	 * @return void
	 */
	public function renderAction() {

		switch($this->data['CType']) {
			case 'bullets':
				$this->forward('bullets');
				break;
			case 'image':
				$this->forward('image');
				break;
			case 'menu':
				$this->forward('menu');
				break;
			case 'table':
				$this->forward('table');
				break;
			case 'textpic':
				$this->forward('textpic');
				break;
			case 'uploads':
				$this->forward('uploads');
				break;
		}
	}

	/**
	 * Action for CE "Bullet list"
	 *
	 * The field "bodytext" contains the bullet lines, separated by a line feed.
	 * It's transformed to an array before sending it to the view.
	 *
	 * @return void
	 */
	public function bulletsAction() {
		$this->data['bullets']['data'] = \PatrickBroens\Contentelements\Utilities\Transform::CsvToArray(
			$this->data['bodytext'],
			'|',
			'',
			2
		);

		$this->view->assign('data', $this->data);
	}

	/**
	 * Action for CE "Images"
	 *
	 * Files are FAL references, stored as comma separated values in a temporary field "image_fileReferenceUids".
	 * The files are collected by these references before sending it to the view.
	 *
	 * Sets the gallery position as variables, for better usability in Fluid templates.
	 *
	 * @return void
	 */
	public function imageAction() {
		$fileObjects = $this->fileCollection->getAllSorted(
			'',
			$this->data['image_fileReferenceUids']
		);

		$this->data['images'] = $fileObjects;

		$this->galleryPosition();
		$this->galleryWidth();

		$this->view->assign('data', $this->data);
	}

	/**
	 * Action for CE "Menu / Sitemap"
	 *
	 * The fields "pages" and "selected_categories" contain the selected pages/categories, stored as comma separated values.
	 * Before sending it to the view they are transformed to an array of integers, instead of a string.
	 * The values are filtered on removing zero and duplicates.
	 *
	 * @return void
	 */
	public function menuAction() {
		$this->data['pages'] = array_filter(array_unique(GeneralUtility::intExplode(
			',',
			$this->data['pages'],
			TRUE
		)));
		$this->data['selected_categories'] = array_filter(array_unique(GeneralUtility::intExplode(
			',',
			$this->data['selected_categories'],
			TRUE
		)));

		$this->view->assign('data', $this->data);
	}

	/**
	 * Action for CE "Table"
	 *
	 * The table data is stored in the field "bodytext" as a string, where each line, separated by line feed,
	 * represents a row. By default columns are separated by the delimiter character "vertical line |",
	 * and can be enclosed (not default), like a regular CSV file.
	 *
	 * The table data is transformed to a multi dimensional array, taking the delimiter and enclosure into account,
	 * before it is passed to the view.
	 *
	 * Some data of a table is stored in a FlexForm,
	 * and is put in the "table" value to be able to read it in a Fluid template.
	 *
	 * @return void
	 */
	public function tableAction() {
		$flexForm = \TYPO3\CMS\Core\Utility\GeneralUtility::xml2array($this->data['pi_flexform']);
		$this->data['table'] = array();

		$delimiterCharacterCode = FlexForm::getFlexFormValue($flexForm, 'tableparsing_delimiter', 's_parsing');

		if ($delimiterCharacterCode) {
			$delimiter = chr(intval($delimiterCharacterCode));
		} else {
			$delimiter = '|';
		}

		$enclosureCharacterCode = FlexForm::getFlexFormValue($flexForm, 'tableparsing_quote', 's_parsing');

		if ($enclosureCharacterCode) {
			$enclosure = chr(intval($enclosureCharacterCode));
		} else {
			$enclosure = '';
		}

		$this->data['table']['data'] = \PatrickBroens\Contentelements\Utilities\Transform::CsvToArray(
			$this->data['bodytext'],
			$delimiter,
			$enclosure,
			$this->data['cols']
		);

		$this->data['table']['caption'] = FlexForm::getFlexFormValue($flexForm, 'acctables_caption');
		$this->data['table']['useFooter'] = FlexForm::getFlexFormValue($flexForm, 'acctables_tfoot');
		$this->data['table']['headerPosition'] = FlexForm::getFlexFormValue($flexForm, 'acctables_headerpos');
		$this->data['table']['class'] = FlexForm::getFlexFormValue($flexForm, 'acctables_tableclass');

		$this->view->assign('data', $this->data);
	}

	/**
	 * Action for CE "Text & Images"
	 *
	 * Files are FAL references, stored as comma separated values in a temporary field "image_fileReferenceUids".
	 * The files are collected by these references before sending it to the view.
	 *
	 * Sets the gallery position as variables, for better usability in Fluid templates.
	 *
	 * @return void
	 */
	public function textpicAction() {
		$fileObjects = $this->fileCollection->getAllSorted(
			'',
			$this->data['image_fileReferenceUids']
		);

		$this->data['images'] = $fileObjects;

		$this->galleryPosition();
		$this->galleryWidth();

		$this->view->assign('data', $this->data);
	}

	/**
	 * Action for the CE "File links"
	 *
	 * Gets all file objects before passing it to the view.
	 *
	 * @return void
	 */
	public function uploadsAction() {
		$fileObjects = $this->fileCollection->getAllSorted(
			'',
			$this->data['media_fileReferenceUids'],
			$this->data['file_collections'],
			$this->data['select_key'],
			$this->data['filelink_sorting']
		);

		$this->data['files'] = $fileObjects;

		$this->view->assign('data', $this->data);
	}

	/**
	 * Define the gallery position, based on field "imageorient"
	 *
	 * Gallery has a horizontal and a vertical position towards the text
	 * and a possible wrapping of the text around the gallery.
	 *
	 * @return void
	 */
	protected function galleryPosition() {
		$galleryPosition = array(
			'horizontal' => array(
				'center' => array(0, 8),
				'right' => array(1, 9, 17, 25),
				'left' => array(2, 10, 18, 26)
			),
			'vertical' => array(
				'above' => array(0, 1, 2),
				'intext' => array(17, 18, 25, 26),
				'below' => array(8, 9, 10)
			)
		);

		foreach ($galleryPosition as $positionDirectionKey => $positionDirectionValue) {
			foreach ($positionDirectionValue as $positionKey => $positionArray) {
				if (in_array($this->data['imageorient'], $positionArray)) {
					$this->data['galleryPosition'][$positionDirectionKey] = $positionKey;
				}
			}
		}

		if (in_array($this->data['imageorient'], array(25, 26))) {
			$this->data['galleryPosition']['noWrap'] = TRUE;
		}
	}

	/**
	 * Set the gallery width based on vertical position and register settings
	 *
	 * @return void
	 */
	protected function galleryWidth() {
		if ($this->data['galleryPosition']['vertical'] === 'intext') {
			if ($GLOBALS['TSFE']->register['maxImageWidthInText']) {
				$this->data['galleryWidth'] = $GLOBALS['TSFE']->register['maxImageWidthInText'];
			} else {
				$this->data['galleryWidth'] = $this->settings['maximumImageWidthInText'];
			}
		} else {
			if ($GLOBALS['TSFE']->register['maxImageWidth']) {
				$this->data['galleryWidth'] = $GLOBALS['TSFE']->register['maxImageWidth'];
			} else {
				$this->data['galleryWidth'] = $this->settings['maximumImageWidth'];
			}
		}
	}
}