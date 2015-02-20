<?php
if (!defined('TYPO3_MODE')) {
	die('Access denied.');
}

	// Define TypoScript as content rendering template
$GLOBALS['TYPO3_CONF_VARS']['FE']['contentRenderingTemplates'] = array(
	'contentelements/Configuration/TypoScript/Static/'
);

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
	'PatrickBroens.' . $_EXTKEY,
	'Contentelements',
	array(
		'ContentElement' => 'render'
	),
	array()
);

	// Remove obsolete fields and set some defaults
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPageTSConfig(
	'<INCLUDE_TYPOSCRIPT: source="FILE:EXT:contentelements/Configuration/TypoScript/PageTSconfig/default.ts">'
);

	// Minimum set of fields, recommended for beginners, when showMinimumSetOfFields is set to 1 in Extension Manager
if ($_EXTCONF['showMinimumSetOfFields']) {
	\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPageTSConfig(
		'<INCLUDE_TYPOSCRIPT: source="FILE:EXT:contentelements/Configuration/TypoScript/PageTSconfig/minimum.ts">'
	);
}