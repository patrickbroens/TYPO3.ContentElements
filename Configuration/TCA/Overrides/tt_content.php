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

// Add a new palette for default appearance options
$GLOBALS['TCA']['tt_content']['palettes']['appearanceLinks'] = array(
	'canNotCollapse' => 1,
	'showitem' => '
		sectionIndex;LLL:EXT:cms/locallang_ttc.xlf:sectionIndex_formlabel,
		linkToTop;LLL:EXT:cms/locallang_ttc.xlf:linkToTop_formlabel
	'
);

/***********************************
 * CE "Bullets" (tt_content.bullets)
 ***********************************/

// Restructure the form layout (tabs, palettes and fields)
$GLOBALS['TCA']['tt_content']['types']['bullets']['showitem'] = '
		--palette--;LLL:EXT:cms/locallang_ttc.xlf:palette.general;general,
		--palette--;LLL:EXT:cms/locallang_ttc.xlf:palette.header;header,
		bodytext;LLL:EXT:cms/locallang_ttc.xlf:bodytext.ALT.bulletlist_formlabel;;nowrap,
	--div--;LLL:EXT:cms/locallang_ttc.xlf:tabs.appearance,
		layout;LLL:EXT:cms/locallang_ttc.xlf:layout_formlabel,
		bullets_type;;;;1-1-1,
		--palette--;LLL:EXT:contentelements/Resources/Private/Language/TCA.xlf:palette.appearanceLinks;appearanceLinks,
	--div--;LLL:EXT:cms/locallang_ttc.xlf:tabs.access,
		hidden;LLL:EXT:contentelements/Resources/Private/Language/TCA.xlf:field.default.hidden,
		--palette--;LLL:EXT:cms/locallang_ttc.xlf:palette.access;access,
	--div--;LLL:EXT:cms/locallang_ttc.xlf:tabs.extended,
	--div--;LLL:EXT:lang/locallang_tca.xlf:sys_category.tabs.category,
		categories
';

/*******************************
 * CE "Divider" (tt_content.div)
 *******************************/

// Restructure the form layout (tabs, palettes and fields)
$GLOBALS['TCA']['tt_content']['types']['div']['showitem'] = '
		--palette--;LLL:EXT:cms/locallang_ttc.xlf:palette.general;general,
		header;LLL:EXT:cms/locallang_ttc.xlf:header.ALT.div_formlabel,
	--div--;LLL:EXT:cms/locallang_ttc.xlf:tabs.appearance,
		layout;LLL:EXT:cms/locallang_ttc.xlf:layout_formlabel,
		--palette--;LLL:EXT:contentelements/Resources/Private/Language/TCA.xlf:palette.appearanceLinks;appearanceLinks,
	--div--;LLL:EXT:cms/locallang_ttc.xlf:tabs.access,
		hidden;LLL:EXT:contentelements/Resources/Private/Language/TCA.xlf:field.default.hidden,
		--palette--;LLL:EXT:cms/locallang_ttc.xlf:palette.access;access,
	--div--;LLL:EXT:cms/locallang_ttc.xlf:tabs.extended,
	--div--;LLL:EXT:lang/locallang_tca.xlf:sys_category.tabs.category,
		categories
';

/*********************************
 * CE "Header" (tt_content.header)
 *********************************/

// Restructure the form layout (tabs, palettes and fields)
$GLOBALS['TCA']['tt_content']['types']['header']['showitem'] = '
		--palette--;LLL:EXT:cms/locallang_ttc.xlf:palette.general;general,
		--palette--;LLL:EXT:cms/locallang_ttc.xlf:palette.headers;headers,
	--div--;LLL:EXT:cms/locallang_ttc.xlf:tabs.appearance,
		layout;LLL:EXT:cms/locallang_ttc.xlf:layout_formlabel,
		--palette--;LLL:EXT:contentelements/Resources/Private/Language/TCA.xlf:palette.appearanceLinks;appearanceLinks,
	--div--;LLL:EXT:cms/locallang_ttc.xlf:tabs.access,
		hidden;LLL:EXT:contentelements/Resources/Private/Language/TCA.xlf:field.default.hidden,
		--palette--;LLL:EXT:cms/locallang_ttc.xlf:palette.access;access,
	--div--;LLL:EXT:cms/locallang_ttc.xlf:tabs.extended,
	--div--;LLL:EXT:lang/locallang_tca.xlf:sys_category.tabs.category,
		categories
';
/*****************************
 * CE "HTML" (tt_content.html)
 *****************************/

// Restructure the form layout (tabs, palettes and fields)
$GLOBALS['TCA']['tt_content']['types']['html']['showitem'] = '
		--palette--;LLL:EXT:cms/locallang_ttc.xlf:palette.general;general,
		header;LLL:EXT:cms/locallang_ttc.xlf:header.ALT.html_formlabel,
		bodytext;LLL:EXT:cms/locallang_ttc.xlf:bodytext.ALT.html_formlabel;;nowrap:wizards[t3editor],
	--div--;LLL:EXT:cms/locallang_ttc.xlf:tabs.appearance,
		layout;LLL:EXT:cms/locallang_ttc.xlf:layout_formlabel,
		--palette--;LLL:EXT:contentelements/Resources/Private/Language/TCA.xlf:palette.appearanceLinks;appearanceLinks,
	--div--;LLL:EXT:cms/locallang_ttc.xlf:tabs.access,
		hidden;LLL:EXT:contentelements/Resources/Private/Language/TCA.xlf:field.default.hidden,
		--palette--;LLL:EXT:cms/locallang_ttc.xlf:palette.access;access,
	--div--;LLL:EXT:cms/locallang_ttc.xlf:tabs.extended,
	--div--;LLL:EXT:lang/locallang_tca.xlf:sys_category.tabs.category,
		categories
';

/**************************************
 * CE "Insert Plugin" (tt_content.list)
 **************************************/

// Restructure the form layout (tabs, palettes and fields)
$GLOBALS['TCA']['tt_content']['types']['list']['showitem'] = '
		--palette--;LLL:EXT:cms/locallang_ttc.xlf:palette.general;general,
		--palette--;LLL:EXT:cms/locallang_ttc.xlf:palette.header;header,
	--div--;LLL:EXT:cms/locallang_ttc.xlf:tabs.plugin,
		list_type;LLL:EXT:cms/locallang_ttc.xlf:list_type_formlabel,
		select_key;LLL:EXT:cms/locallang_ttc.xlf:select_key_formlabel,
		pages;LLL:EXT:cms/locallang_ttc.xlf:pages.ALT.list_formlabel,
		recursive,
	--div--;LLL:EXT:cms/locallang_ttc.xlf:tabs.appearance,
		layout;LLL:EXT:cms/locallang_ttc.xlf:layout_formlabel,
		--palette--;LLL:EXT:contentelements/Resources/Private/Language/TCA.xlf:palette.appearanceLinks;appearanceLinks,
	--div--;LLL:EXT:cms/locallang_ttc.xlf:tabs.access,
		hidden;LLL:EXT:contentelements/Resources/Private/Language/TCA.xlf:field.default.hidden,
		--palette--;LLL:EXT:cms/locallang_ttc.xlf:palette.access;access,
	--div--;LLL:EXT:cms/locallang_ttc.xlf:tabs.extended,
	--div--;LLL:EXT:lang/locallang_tca.xlf:sys_category.tabs.category,
		categories
';

/**************************************
 * CE "Special Menus" (tt_content.menu)
 **************************************/

// Restructure the form layout (tabs, palettes and fields)
$GLOBALS['TCA']['tt_content']['types']['menu']['showitem'] = '
		--palette--;LLL:EXT:cms/locallang_ttc.xlf:palette.general;general,
		--palette--;LLL:EXT:cms/locallang_ttc.xlf:palette.header;header,
		--palette--;LLL:EXT:cms/locallang_ttc.xlf:palette.menu;menu,
	--div--;LLL:EXT:cms/locallang_ttc.xlf:tabs.appearance,
		layout;LLL:EXT:cms/locallang_ttc.xlf:layout_formlabel,
		--palette--;LLL:EXT:contentelements/Resources/Private/Language/TCA.xlf:palette.appearanceLinks;appearanceLinks,
	--div--;LLL:EXT:cms/locallang_ttc.xlf:tabs.access,
		hidden;LLL:EXT:contentelements/Resources/Private/Language/TCA.xlf:field.default.hidden,
		--palette--;LLL:EXT:cms/locallang_ttc.xlf:palette.access;access,
	--div--;LLL:EXT:contentelements/Resources/Private/Language/TCA.xlf:tabs.accessibility,
		--palette--;LLL:EXT:cms/locallang_ttc.xlf:palette.menu_accessibility;menu_accessibility,
	--div--;LLL:EXT:cms/locallang_ttc.xlf:tabs.extended,
	--div--;LLL:EXT:lang/locallang_tca.xlf:sys_category.tabs.category,
		categories
';

/*******************************************
 * CE "Insert Records" (tt_content.shortcut)
 *******************************************/

// Restructure the form layout (tabs, palettes and fields)
$GLOBALS['TCA']['tt_content']['types']['shortcut']['showitem'] = '
		--palette--;LLL:EXT:cms/locallang_ttc.xlf:palette.general;general,
		header;LLL:EXT:cms/locallang_ttc.xlf:header.ALT.shortcut_formlabel,
		records;LLL:EXT:cms/locallang_ttc.xlf:records_formlabel,
	--div--;LLL:EXT:cms/locallang_ttc.xlf:tabs.appearance,
		layout;LLL:EXT:cms/locallang_ttc.xlf:layout_formlabel,
		--palette--;LLL:EXT:contentelements/Resources/Private/Language/TCA.xlf:palette.appearanceLinks;appearanceLinks,
	--div--;LLL:EXT:cms/locallang_ttc.xlf:tabs.access,
		hidden;LLL:EXT:contentelements/Resources/Private/Language/TCA.xlf:field.default.hidden,
		--palette--;LLL:EXT:cms/locallang_ttc.xlf:palette.access;access,
	--div--;LLL:EXT:cms/locallang_ttc.xlf:tabs.extended,
	--div--;LLL:EXT:lang/locallang_tca.xlf:sys_category.tabs.category,
		categories
';

/*******************************
 * CE "Table" (tt_content.table)
 *******************************/

// Add a new palette
$GLOBALS['TCA']['tt_content']['palettes']['tableconfiguration'] = array(
	'canNotCollapse' => 1,
	'showitem' => 'table_delimiter, table_enclosure'
);

// Add the fields "cols", "table_header_position", "table_tfoot" to TCA for palette "tablelayout"
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addFieldsToPalette(
	'tt_content',
	'tablelayout',
	'cols, table_header_position, table_tfoot'
);

// Restructure the form layout (tabs, palettes and fields)
$GLOBALS['TCA']['tt_content']['types']['table']['showitem'] = '
		--palette--;LLL:EXT:cms/locallang_ttc.xlf:palette.general;general,
		--palette--;LLL:EXT:cms/locallang_ttc.xlf:palette.header;header,
		bodytext;;tableconfiguration;nowrap:wizards[table], table_caption,
	--div--;LLL:EXT:cms/locallang_ttc.xlf:tabs.appearance,
		layout;LLL:EXT:cms/locallang_ttc.xlf:layout_formlabel,
		--palette--;LLL:EXT:cms/locallang_ttc.xlf:palette.table_layout;tablelayout,
		--palette--;LLL:EXT:contentelements/Resources/Private/Language/TCA.xlf:palette.appearanceLinks;appearanceLinks,
	--div--;LLL:EXT:cms/locallang_ttc.xlf:tabs.access,
		hidden;LLL:EXT:contentelements/Resources/Private/Language/TCA.xlf:field.default.hidden,
		--palette--;LLL:EXT:cms/locallang_ttc.xlf:palette.access;access,
	--div--;LLL:EXT:cms/locallang_ttc.xlf:tabs.extended,
	--div--;LLL:EXT:lang/locallang_tca.xlf:sys_category.tabs.category,
		categories
';

/*****************************************
 * CE "Text & Media" (tt_content.textmedia)
 *****************************************/
// Insert this element in the "Standard" optgroup of CType dropdown
array_splice(
	$GLOBALS['TCA']['tt_content']['columns']['CType']['config']['items'],
	2,
	0,
	array(
		array(
			'LLL:EXT:contentelements/Resources/Private/Language/TCA.xlf:tt_content.textmedia',
			'textmedia',
			'i/tt_content_textpic.gif'
		)
	)
);

// Add a new palette for media adjustments
$GLOBALS['TCA']['tt_content']['palettes']['mediaAdjustments'] = array(
	'canNotCollapse' => 1,
	'showitem' => '
		imagewidth;LLL:EXT:contentelements/Resources/Private/Language/TCA.xlf:field.textmedia.imagewidth,
		imageheight;LLL:EXT:contentelements/Resources/Private/Language/TCA.xlf:field.textmedia.imageheight,
		imageborder;LLL:EXT:contentelements/Resources/Private/Language/TCA.xlf:field.textmedia.imageborder
	'
);

// Add a new palette for gallery settings
$GLOBALS['TCA']['tt_content']['palettes']['gallerySettings'] = array(
	'canNotCollapse' => 1,
	'showitem' => '
		imageorient;LLL:EXT:cms/locallang_ttc.xlf:imageorient_formlabel,
		imagecols;LLL:EXT:cms/locallang_ttc.xlf:imagecols_formlabel
	'
);

// Add icon for this type of content element
$GLOBALS['TCA']['tt_content']['ctrl']['typeicons']['textmedia'] = 'tt_content_textpic.gif';
$GLOBALS['TCA']['tt_content']['ctrl']['typeicon_classes']['textmedia'] =  'mimetypes-x-content-text-media';

// Restructure the form layout (tabs, palettes and fields)
$GLOBALS['TCA']['tt_content']['types']['textmedia']['showitem'] = '
		--palette--;LLL:EXT:cms/locallang_ttc.xlf:palette.general;general,
		--palette--;LLL:EXT:cms/locallang_ttc.xlf:palette.header;header,
		bodytext;LLL:EXT:cms/locallang_ttc.xlf:bodytext_formlabel;;richtext:rte_transform[flag=rte_enabled|mode=ts_css],
		rte_enabled;LLL:EXT:cms/locallang_ttc.xlf:rte_enabled_formlabel,
	--div--;LLL:EXT:cms/locallang_ttc.xlf:tabs.media,
		image,
		--palette--;LLL:EXT:cms/locallang_ttc.xlf:palette.imagelinks;imagelinks,
	--div--;LLL:EXT:cms/locallang_ttc.xlf:tabs.appearance,
		layout;LLL:EXT:cms/locallang_ttc.xlf:layout_formlabel,
		--palette--;LLL:EXT:contentelements/Resources/Private/Language/TCA.xlf:palette.mediaAdjustments;mediaAdjustments,
		--palette--;LLL:EXT:contentelements/Resources/Private/Language/TCA.xlf:palette.gallerySettings;gallerySettings,
		--palette--;LLL:EXT:contentelements/Resources/Private/Language/TCA.xlf:palette.appearanceLinks;appearanceLinks,
	--div--;LLL:EXT:cms/locallang_ttc.xlf:tabs.access,
		hidden;LLL:EXT:contentelements/Resources/Private/Language/TCA.xlf:field.default.hidden,
		--palette--;LLL:EXT:cms/locallang_ttc.xlf:palette.access;access,
	--div--;LLL:EXT:cms/locallang_ttc.xlf:tabs.extended,
	--div--;LLL:EXT:lang/locallang_tca.xlf:sys_category.tabs.category,
		categories
';

/**************************************
 * CE "File Links" (tt_content.uploads)
 **************************************/

// Add the fields "uploads_description" and "uploads_type" to TCA for palette "uploadslayout"
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addFieldsToPalette(
	'tt_content',
	'uploadslayout',
	'uploads_description, uploads_type'
);

// Restructure the form layout (tabs, palettes and fields)
$GLOBALS['TCA']['tt_content']['types']['text']['showitem'] = '
		--palette--;LLL:EXT:cms/locallang_ttc.xlf:palette.general;general,
		--palette--;LLL:EXT:cms/locallang_ttc.xlf:palette.header;header,
		--palette--;LLL:EXT:cms/locallang_ttc.xlf:media;uploads,
	--div--;LLL:EXT:cms/locallang_ttc.xlf:tabs.appearance,
		layout;LLL:EXT:cms/locallang_ttc.xlf:layout_formlabel,
		--palette--;LLL:EXT:cms/locallang_ttc.xlf:palette.uploads_layout;uploadslayout,
		 --palette--;LLL:EXT:contentelements/Resources/Private/Language/TCA.xlf:palette.appearanceLinks;appearanceLinks,
	--div--;LLL:EXT:cms/locallang_ttc.xlf:tabs.access,
		hidden;LLL:EXT:contentelements/Resources/Private/Language/TCA.xlf:field.default.hidden,
		--palette--;LLL:EXT:cms/locallang_ttc.xlf:palette.access;access,
	--div--;LLL:EXT:cms/locallang_ttc.xlf:tabs.extended,
	--div--;LLL:EXT:lang/locallang_tca.xlf:sys_category.tabs.category,
		categories
';