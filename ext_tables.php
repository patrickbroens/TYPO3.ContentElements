<?php
if(!defined ('TYPO3_MODE')){
    die('Access denied.');
}

	// Add an entry in the static template list found in sys_templates
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile(
	$_EXTKEY,
	'Configuration/TypoScript',
	'Content Elements'
);