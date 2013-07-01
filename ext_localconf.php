<?php
if (!defined('TYPO3_MODE')) {
	die('Access denied.');
}

	// Define TypoScript as content rendering template
$GLOBALS['TYPO3_CONF_VARS']['FE']['contentRenderingTemplates'] = array(
	'contentelements/Configuration/TypoScript/'
);