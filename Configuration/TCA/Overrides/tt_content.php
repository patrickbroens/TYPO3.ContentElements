<?php
defined('TYPO3_MODE') or die();

//Extra fields for the tt_content table
$extraContentColumns = array(
	'bullets_type' => array(
		'exclude' => TRUE,
		'label' => 'LLL:EXT:contentelements/Resources/Private/Language/Database.xlf:tt_content.bullets_type',
		'config' => array(
			'type' => 'select',
			'items' => array(
				array('LLL:EXT:contentelements/Resources/Private/Language/Database.xlf:tt_content.bullets_type.0', 0),
				array('LLL:EXT:contentelements/Resources/Private/Language/Database.xlf:tt_content.bullets_type.1', 1),
				array('LLL:EXT:contentelements/Resources/Private/Language/Database.xlf:tt_content.bullets_type.2', 2)
			),
			'default' => 0
		)
	),
	'table_caption' => array(
		'exclude' => TRUE,
		'label' => 'LLL:EXT:contentelements/Resources/Private/Language/Database.xlf:tt_content.table_caption',
		'config' => array(
			'type' => 'input'
		)
	),
	'table_delimiter' => array(
		'exclude' => TRUE,
		'label' => 'LLL:EXT:contentelements/Resources/Private/Language/Database.xlf:tt_content.table_delimiter',
		'config' => array(
			'type' => 'select',
			'items' => array(
				array('LLL:EXT:contentelements/Resources/Private/Language/Database.xlf:tt_content.table_delimiter.124', 124),
				array('LLL:EXT:contentelements/Resources/Private/Language/Database.xlf:tt_content.table_delimiter.59', 59),
				array('LLL:EXT:contentelements/Resources/Private/Language/Database.xlf:tt_content.table_delimiter.44', 44),
				array('LLL:EXT:contentelements/Resources/Private/Language/Database.xlf:tt_content.table_delimiter.58', 58),
				array('LLL:EXT:contentelements/Resources/Private/Language/Database.xlf:tt_content.table_delimiter.9', 9)
			),
			'default' => 124
		)
	),
	'table_enclosure' => array(
		'exclude' => TRUE,
		'label' => 'LLL:EXT:contentelements/Resources/Private/Language/Database.xlf:tt_content.table_enclosure',
		'config' => array(
			'type' => 'select',
			'items' => array(
				array('LLL:EXT:contentelements/Resources/Private/Language/Database.xlf:tt_content.table_enclosure.0', 0),
				array('LLL:EXT:contentelements/Resources/Private/Language/Database.xlf:tt_content.table_enclosure.39', 39),
				array('LLL:EXT:contentelements/Resources/Private/Language/Database.xlf:tt_content.table_enclosure.34', 34)
			),
			'default' => 0
		)
	),
	'table_header_position' => array(
		'exclude' => TRUE,
		'label' => 'LLL:EXT:contentelements/Resources/Private/Language/Database.xlf:tt_content.table_header_position',
		'config' => array(
			'type' => 'select',
			'items' => array(
				array('LLL:EXT:contentelements/Resources/Private/Language/Database.xlf:tt_content.table_header_position.0', 0),
				array('LLL:EXT:contentelements/Resources/Private/Language/Database.xlf:tt_content.table_header_position.1', 1),
				array('LLL:EXT:contentelements/Resources/Private/Language/Database.xlf:tt_content.table_header_position.2', 2)
			),
			'default' => 0
		)
	),
	'table_tfoot' => array(
		'exclude' => TRUE,
		'label' => 'LLL:EXT:contentelements/Resources/Private/Language/Database.xlf:tt_content.table_tfoot',
		'config' => array(
			'type' => 'check',
			'default' => 0,
			'items' => array(
				array('LLL:EXT:lang/locallang_core.xml:labels.enabled', 1)
			)
		)
	),
	'uploads_description' => array(
		'exclude' => TRUE,
		'label' => 'LLL:EXT:contentelements/Resources/Private/Language/Database.xlf:tt_content.uploads_description',
		'config' => array(
			'type' => 'check',
			'default' => 0,
			'items' => array(
				array('LLL:EXT:lang/locallang_core.xml:labels.enabled', 1)
			)
		)
	),
	'uploads_type' => array(
		'exclude' => TRUE,
		'label' => 'LLL:EXT:contentelements/Resources/Private/Language/Database.xlf:tt_content.uploads_type',
		'config' => array(
			'type' => 'select',
			'items' => array(
				array('LLL:EXT:contentelements/Resources/Private/Language/Database.xlf:tt_content.uploads_type.0', 0),
				array('LLL:EXT:contentelements/Resources/Private/Language/Database.xlf:tt_content.uploads_type.1', 1),
				array('LLL:EXT:contentelements/Resources/Private/Language/Database.xlf:tt_content.uploads_type.2', 2)
			),
			'default' => 0
		)
	)
);

// Adding fields to the tt_content table definition in TCA
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTCAcolumns('tt_content', $extraContentColumns);

/**
 * CE "Bullets"
 */

// Add the field "bullets_type" to TCA for type "bullets"
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addToAllTCAtypes(
	'tt_content',
	'bullets_type;;;;1-1-1',
	'bullets',
	'after:layout'
);

/**
 * CE "File links"
 */

// Add the fields "uploads_description" and "uploads_type" to TCA for palette "uploadslayout"
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addFieldsToPalette(
	'tt_content',
	'uploadslayout',
	'uploads_description, uploads_type'
);

/**
 * CE "Table"
 */

// Add a new palette
$GLOBALS['TCA']['tt_content']['palettes']['tableconfiguration'] = array(
	'canNotCollapse' => 1,
	'showitem' => 'table_delimiter, table_enclosure'
) ;

// Add the fields "cols", "table_header_position", "table_tfoot" to TCA for palette "tablelayout"
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addFieldsToPalette(
	'tt_content',
	'tablelayout',
	'cols, table_header_position, table_tfoot'
);

// Restructure the TCA to have the fields in the proper tabs and palettes
$GLOBALS['TCA']['tt_content']['types']['table']['showitem'] = '
	--palette--;LLL:EXT:cms/locallang_ttc.xlf:palette.general;general,
	--palette--;LLL:EXT:cms/locallang_ttc.xlf:palette.header;header,
		bodytext;;tableconfiguration;nowrap:wizards[table], table_caption,
	--div--;LLL:EXT:cms/locallang_ttc.xlf:tabs.appearance,
		--palette--;LLL:EXT:cms/locallang_ttc.xlf:palette.frames;frames,
		--palette--;LLL:EXT:cms/locallang_ttc.xlf:palette.table_layout;tablelayout,
	--div--;LLL:EXT:cms/locallang_ttc.xlf:tabs.access,
		--palette--;LLL:EXT:cms/locallang_ttc.xlf:palette.visibility;visibility,
		--palette--;LLL:EXT:cms/locallang_ttc.xlf:palette.access;access,
	--div--;LLL:EXT:cms/locallang_ttc.xlf:tabs.extended,
	--div--;LLL:EXT:lang/locallang_tca.xlf:sys_category.tabs.category, categories
';