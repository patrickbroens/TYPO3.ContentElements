<?php
if (!defined('TYPO3_MODE')) {
	die('Access denied.');
}

	// Add an entry in the static template list found in sys_templates
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile(
	$_EXTKEY,
	'Configuration/TypoScript',
	'Content Elements'
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