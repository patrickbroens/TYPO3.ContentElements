<?php
namespace PatrickBroens\Contentelements\Resource\Collection;

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

use TYPO3\CMS\Core\Utility\GeneralUtility;

class FileCollection {

	/**
	 * The files
	 *
	 * @var array
	 */
	protected $files = array();

	/**
	 * The file repository
	 *
	 * @var \TYPO3\CMS\Core\Resource\FileRepository
	 */
	protected $fileRepository;

	/**
	 * The file collection repository
	 *
	 * @var \TYPO3\CMS\Core\Resource\FileCollectionRepository
	 */
	protected $fileCollectionRepository;

	/**
	 * The resource factory
	 *
	 * @var \TYPO3\CMS\Core\Resource\ResourceFactory
	 */
	protected $resourceFactory;

	/**
	 * Constructor
	 *
	 * @return void
	 */
	public function __construct() {
		$this->fileRepository = GeneralUtility::makeInstance('TYPO3\\CMS\\Core\\Resource\\FileRepository');
		$this->fileCollectionRepository = GeneralUtility::makeInstance('TYPO3\\CMS\\Core\\Resource\\FileCollectionRepository');
		$this->resourceFactory = GeneralUtility::makeInstance('TYPO3\\CMS\\Core\\Resource\\ResourceFactory');
	}

	/**
	 * Get all the files from references, file collections and folders, sorted by property
	 *
	 * @param string $fileUids The file uids, comma separated
	 * @param string $referencesUids The references uids, comma separated
	 * @param string $fileCollectionUids The file collections uids, comma separated
	 * @param string $folderIdentifiers The folder identifiers, comma separated
	 * @param string $sortingProperty The property to sort the files with
	 * @return array The files
	 */
	public function getAllSorted(
		$fileUids = '',
		$referencesUids = '',
		$fileCollectionUids = '',
		$folderIdentifiers = '',
		$sortingProperty = ''
	) {
		$this->addAll($fileUids, $referencesUids, $fileCollectionUids, $folderIdentifiers);

		$this->sort($sortingProperty);

		return $this->files;
	}

	/**
	 * Get all the files from references, file collections and folders, in order of incoming values
	 *
	 * @param string $fileUids The file uids, comma separated
	 * @param string $referencesUids The references uids, comma separated
	 * @param string $fileCollectionUids The file collections uids, comma separated
	 * @param string $folderIdentifiers The folder identifiers, comma separated
	 * @return array The files
	 */
	public function getAll($fileUids, $referencesUids = '', $fileCollectionUids = '', $folderIdentifiers = '') {
		$this->addAll($fileUids, $referencesUids, $fileCollectionUids, $folderIdentifiers);

		return $this->files;
	}

	/**
	 * Add files to the collection from references, file collections and folders
	 *
	 * @param string $fileUids The file uids, comma separated
	 * @param string $referencesUids The references uids, comma separated
	 * @param string $fileCollectionUids The file collections uids, comma separated
	 * @param string $folderIdentifiers The folder identifiers, comma separated
	 * @return void
	 */
	public function addAll($fileUids, $referencesUids = '', $fileCollectionUids = '', $folderIdentifiers = '') {
		$this->addFiles($fileUids);
		$this->addFilesFromReferences($referencesUids);
		$this->addFilesFromFileCollections($fileCollectionUids);
		$this->addFilesFromFolders($folderIdentifiers);
	}

	/**
	 * Add files to the collection from multiple UIDs
	 *
	 * @param $fileUids
	 * @return void
	 */
	public function addFiles($fileUids) {
		$fileUids = GeneralUtility::trimExplode(',', $fileUids, TRUE);

		foreach($fileUids as $fileUid) {
			$this->add($this->fileRepository->findByUid($fileUid));
		}
	}

	/**
	 * Add files to the collection from multiple references
	 *
	 * @param string $referencesUids The references uids, comma separated
	 * @return void
	 */
	public function addFilesFromReferences($referencesUids) {
		$referencesUids = GeneralUtility::trimExplode(',', $referencesUids, TRUE);

		foreach($referencesUids as $referenceUid) {
			$this->addFileFromReference($referenceUid);
		}
	}

	/**
	 * Add file to the collection from one single reference
	 *
	 * @param integer $referenceUid The reference uid
	 * @return void
	 */
	public function addFileFromReference($referenceUid) {
		$fileReference = $this->fileRepository->findFileReferenceByUid($referenceUid);

		$this->add($fileReference);
	}

	/**
	 * Add files to the collection from multiple file collections
	 *
	 * @param string $fileCollectionUids The file collections uids, comma separated
	 * @return void
	 */
	public function addFilesFromFileCollections($fileCollectionUids) {
		$fileCollectionUids = GeneralUtility::trimExplode(',', $fileCollectionUids, TRUE);

		foreach($fileCollectionUids as $fileCollectionUid) {
			$this->addFilesFromFileCollection($fileCollectionUid);
		}
	}

	/**
	 * Add files to the collection from one single file collection
	 *
	 * @param integer $fileCollectionUid The file collections uid
	 * @return void
	 */
	public function addFilesFromFileCollection($fileCollectionUid) {
		try {
			$fileCollection = $this->fileCollectionRepository->findByUid($fileCollectionUid);

			if ($fileCollection instanceof \TYPO3\CMS\Core\Resource\Collection\AbstractFileCollection) {
				$fileCollection->loadContents();
				$files = $fileCollection->getItems();
				foreach ($files as $file) {
					$this->add($file);
				}
			}
		} catch (\TYPO3\CMS\Core\Resource\Exception $e) {
			$logger = GeneralUtility::makeInstance('TYPO3\CMS\Core\Log\LogManager')->getLogger();
			$logger->warning('The file-collection with uid  "' . $fileCollectionUid . '" could not be found or contents could not be loaded and won\'t be included in frontend output');
		}
	}

	/**
	 * Add files to the collection from multiple folders
	 *
	 * @param string $folderIdentifiers The folder identifiers, comma separated
	 * @return void
	 */
	public function addFilesFromFolders($folderIdentifiers) {
		$folderIdentifiers = GeneralUtility::trimExplode(',', $folderIdentifiers);

		foreach ($folderIdentifiers as $folderIdentifier) {
			$this->addFilesFromFolder($folderIdentifier);
		}
	}

	/**
	 * Add files to the collection from one single folder
	 *
	 * @param string $folderIdentifier The folder identifier
	 */
	public function addFilesFromFolder($folderIdentifier) {
		if ($folderIdentifier) {
			try {
				$folder = $this->resourceFactory->getFolderObjectFromCombinedIdentifier($folderIdentifier);
				if ($folder instanceof \TYPO3\CMS\Core\Resource\Folder) {
					$files = $folder->getFiles();
					foreach ($files as $file) {
						$this->add($file);
					}
				}
			} catch (\TYPO3\CMS\Core\Resource\Exception $e) {
				$logger = GeneralUtility::makeInstance('TYPO3\CMS\Core\Log\LogManager')->getLogger();
				$logger->warning('The folder with identifier  "' . $folderIdentifier . '" could not be found and won\'t be included in frontend output');
			}
		}
	}

	/**
	 * Sort the file objects based on a property
	 *
	 * @param string $sortingProperty The sorting property
	 * @return void
	 */
	public function sort($sortingProperty = '') {
		if ($sortingProperty !== '' && count($this->files) > 1) {
			usort(
				$fileObjects,
				function(
					\TYPO3\CMS\Core\Resource\FileInterface $a,
					\TYPO3\CMS\Core\Resource\FileInterface $b
				) use($sortingProperty) {
					if ($a->hasProperty($sortingProperty) && $b->hasProperty($sortingProperty)) {
						return strnatcasecmp($a->getProperty($sortingProperty), $b->getProperty($sortingProperty));
					} else {
						return 0;
					}
				}
			);
		}
	}

	/**
	 * Add a file object to the collection
	 *
	 * @param mixed $file The file object
	 * @return void
	 */
	public function add( $file) {
		$this->files[] = $file;
	}
}