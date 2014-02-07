<?php
if (!defined('TYPO3_MODE')) {
	die('Access denied.');
}

	// Add an entry in the static template list found in sys_templates for static TS
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile(
	$_EXTKEY,
	'Configuration/TypoScript/Static',
	'Content Elements'
);

	// Add an entry in the static template list found in sys_templates for CSS TS
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile(
	$_EXTKEY,
	'Configuration/TypoScript/Styling',
	'Content Elements CSS (optional)'
);

/**
 * Extra fields for the tt_content table
 */
$extraContentColumns = array(
	'bullets_type' => array(
		'exclude' => TRUE,
		'label' => 'LLL:EXT:contentelements/Resources/Private/Language/Database.xlf:tt_content.bullets_type',
		'config' => array(
			'type' => 'select',
			'items' => array(
				array('LLL:EXT:contentelements/Resources/Private/Language/Database.xlf:tt_content.bullets_type.ul', 'ul'),
				array('LLL:EXT:contentelements/Resources/Private/Language/Database.xlf:tt_content.bullets_type.ol', 'ol'),
				array('LLL:EXT:contentelements/Resources/Private/Language/Database.xlf:tt_content.bullets_type.dl', 'dl')
			),
			'default' => 'ul'
		)
	),
);

	// Adding fields to the tt_content table definition in TCA
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTCAcolumns('tt_content', $extraContentColumns);

	// Add the field "bullets_type" to TCA for type "bullets"
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addToAllTCAtypes(
	'tt_content',
	'bullets_type;;;;1-1-1',
	'bullets',
	'after:bodytext'
);

	// Add flexform for CE "table"
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPiFlexFormValue(
	'*',
	'FILE:EXT:contentelements/Configuration/FlexForm/Table.xml',
	'table'
);

	// Add the flexform to TCA for CE "table"
$GLOBALS['TCA']['tt_content']['types']['table']['showitem'] = 'CType;;4;;1-1-1, hidden, header;;3;;2-2-2, linkToTop;;;;4-4-4,
			--div--;LLL:EXT:cms/locallang_ttc.xlf:CType.I.5, layout;;10;;3-3-3, cols, bodytext;;9;nowrap:wizards[table], text_properties, pi_flexform,
			--div--;LLL:EXT:cms/locallang_tca.xlf:pages.tabs.access, starttime, endtime, fe_group';