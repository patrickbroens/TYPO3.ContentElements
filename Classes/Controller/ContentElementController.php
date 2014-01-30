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

class ContentElementController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController {

	/**
	 * @var \TYPO3\CMS\Frontend\ContentObject\ContentObjectRenderer
	 */
	protected $contentObject;

	/**
	 * @var mixed
	 */
	protected $data;

	/**
	 * @var \PatrickBroens\Contentelements\Resource\Collection\FileCollection
	 * @inject
	 */
	protected $fileCollection;


	/**
	 * @return void
	 */
	public function initializeAction() {
		$this->contentObject = $this->configurationManager->getContentObject();
		$this->data = $this->contentObject->data;
	}

	/**
	 * @return void
	 */
	public function renderAction() {

		switch($this->data['CType']) {
			case 'bullets':
				$this->forward('bullets');
				break;
			case 'table':
				$this->forward('table');
				break;
			case 'uploads':
				$this->forward('uploads');
				break;
		}
	}

	/**
	 * Action for CE "Bullet list"
	 *
	 * Transforms the bodytext first before it is passed to the view
	 */
	public function bulletsAction() {
		$this->data['bodytext'] = \PatrickBroens\Contentelements\Utilities\Transform::linesToArray(
			$this->data['bodytext']
		);

		$this->view->assign('data', $this->data);
	}

	/**
	 * Action for CE "Table"
	 *
	 * Transforms the table data first to a multi dimensional array before it is passed to the view
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

		$this->view->assign('data', $this->data);
	}

	/**
	 * Action for the CE "File links"
	 *
	 * Gets all file objects before passing it to the view
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
}