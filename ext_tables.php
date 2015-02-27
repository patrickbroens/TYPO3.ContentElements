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