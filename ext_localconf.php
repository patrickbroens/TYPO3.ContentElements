<?php
if (!defined('TYPO3_MODE')) {
	die('Access denied.');
}

	// Define TypoScript as content rendering template
$GLOBALS['TYPO3_CONF_VARS']['FE']['contentRenderingTemplates'] = array(
	'contentelements/Configuration/TypoScript/'
);

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
	'PatrickBroens.' . $_EXTKEY,
	'Contentelements',
	array(
		'ContentElement' => 'render'
	),
	array()
);

	// Remove obsolete fields
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPageTSConfig(
	'<INCLUDE_TYPOSCRIPT: source="FILE:EXT:contentelements/Configuration/TypoScript/PageTSconfig/setup.txt">'
);