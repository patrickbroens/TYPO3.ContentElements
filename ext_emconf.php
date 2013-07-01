<?php

########################################################################
# Extension Manager/Repository config file for ext "contentelements".
#
# Auto generated 08-02-2012 20:49
#
# Manual updates:
# Only the data in the array - everything else is removed by next
# writing. "version" and "dependencies" must not be touched!
########################################################################

$EM_CONF[$_EXTKEY] = array(
	'title' => 'Content Elements',
	'description' => 'Basic set of content elements, based on Fluid templating',
	'category' => 'plugin',
	'shy' => 0,
	'version' => '1.0.0',
	'dependencies' => 'cms',
	'conflicts' => '',
	'priority' => '',
	'loadOrder' => '',
	'module' => '',
	'state' => 'beta',
	'uploadfolder' => 0,
	'createDirs' => '',
	'modify_tables' => '',
	'clearcacheonload' => 0,
	'lockType' => '',
	'author' => 'Patrick Broens',
	'author_email' => 'patrick@patrickbroens.nl',
	'author_company' => 'Patrick Broens',
	'CGLcompliance' => '',
	'CGLcompliance_note' => '',
	'constraints' => array(
		'depends' => array(
			'typo3' => '6.2.0-6.2.99',
			'php' => '5.3.0-0.0.0',
			'cms' => '6.2.0-6.2.99',
			'fluid' => '6.2.0-6.2.99'
		),
		'conflicts' => array(
		),
		'suggests' => array(
		),
	),
	'_md5_values_when_last_written' => 'a:89:{s:21:"ExtensionBuilder.json";s:4:"4ac8";s:12:"ext_icon.gif";s:4:"68b4";s:17:"ext_localconf.php";s:4:"7b4a";s:14:"ext_tables.php";s:4:"d6ec";s:14:"ext_tables.sql";s:4:"7a3f";s:16:"Classes/Core.php";s:4:"2895";s:42:"Classes/Command/DummyCommandController.php";s:4:"1b53";s:41:"Classes/Controller/FoodItemController.php";s:4:"ebe4";s:45:"Classes/Controller/RefrigeratorController.php";s:4:"3381";s:33:"Classes/Domain/Model/FoodItem.php";s:4:"3cd7";s:33:"Classes/Domain/Model/FoodType.php";s:4:"c0b9";s:37:"Classes/Domain/Model/Refrigerator.php";s:4:"1f05";s:48:"Classes/Domain/Repository/FoodItemRepository.php";s:4:"4d85";s:52:"Classes/Domain/Repository/RefrigeratorRepository.php";s:4:"b4b0";s:44:"Configuration/ExtensionBuilder/settings.yaml";s:4:"3e93";s:30:"Configuration/TCA/FoodItem.php";s:4:"2e3b";s:30:"Configuration/TCA/FoodType.php";s:4:"1306";s:34:"Configuration/TCA/Refrigerator.php";s:4:"b349";s:38:"Configuration/TypoScript/constants.txt";s:4:"710b";s:34:"Configuration/TypoScript/setup.txt";s:4:"db5c";s:45:"Resources/Private/Elements/AccessProtect.html";s:4:"3429";s:45:"Resources/Private/Elements/SpecialHeader.html";s:4:"05c5";s:40:"Resources/Private/Language/locallang.xml";s:4:"e68d";s:80:"Resources/Private/Language/locallang_csh_tx_fedexample_domain_model_fooditem.xml";s:4:"6a40";s:80:"Resources/Private/Language/locallang_csh_tx_fedexample_domain_model_foodtype.xml";s:4:"216c";s:84:"Resources/Private/Language/locallang_csh_tx_fedexample_domain_model_refrigerator.xml";s:4:"5e4c";s:43:"Resources/Private/Language/locallang_db.xml";s:4:"61e2";s:38:"Resources/Private/Layouts/Default.html";s:4:"85d8";s:34:"Resources/Private/Layouts/FCE.html";s:4:"c07d";s:35:"Resources/Private/Layouts/Page.html";s:4:"3258";s:41:"Resources/Private/Pages/Page/Default.html";s:4:"3ac1";s:57:"Resources/Private/Pages/Page/SpecialContentRendering.html";s:4:"9eab";s:42:"Resources/Private/Partials/BreadCrumb.html";s:4:"a784";s:38:"Resources/Private/Partials/Footer.html";s:4:"0c8e";s:42:"Resources/Private/Partials/FormErrors.html";s:4:"f5bc";s:36:"Resources/Private/Partials/Menu.html";s:4:"38af";s:39:"Resources/Private/Partials/SubMenu.html";s:4:"8562";s:51:"Resources/Private/Partials/FoodItem/FormFields.html";s:4:"1a82";s:51:"Resources/Private/Partials/FoodItem/Properties.html";s:4:"a5af";s:55:"Resources/Private/Partials/Refrigerator/FormFields.html";s:4:"1e69";s:52:"Resources/Private/Partials/Refrigerator/Preview.html";s:4:"ce9c";s:55:"Resources/Private/Partials/Refrigerator/Properties.html";s:4:"6f51";s:46:"Resources/Private/Templates/FoodItem/Edit.html";s:4:"57f0";s:46:"Resources/Private/Templates/FoodItem/List.html";s:4:"ca51";s:45:"Resources/Private/Templates/FoodItem/New.html";s:4:"e613";s:46:"Resources/Private/Templates/FoodItem/Show.html";s:4:"ca24";s:50:"Resources/Private/Templates/Refrigerator/Edit.html";s:4:"a1ec";s:50:"Resources/Private/Templates/Refrigerator/List.html";s:4:"6370";s:49:"Resources/Private/Templates/Refrigerator/New.html";s:4:"5cdc";s:50:"Resources/Private/Templates/Refrigerator/Show.html";s:4:"b153";s:33:"Resources/Public/Icons/Plugin.png";s:4:"1889";s:35:"Resources/Public/Icons/relation.gif";s:4:"e615";s:62:"Resources/Public/Icons/tx_fedexample_domain_model_fooditem.gif";s:4:"905a";s:62:"Resources/Public/Icons/tx_fedexample_domain_model_foodtype.gif";s:4:"4e5b";s:66:"Resources/Public/Icons/tx_fedexample_domain_model_refrigerator.gif";s:4:"905a";s:61:"Resources/Public/Icons/ThemeSwitcher/theme_30_black_matte.png";s:4:"e767";s:59:"Resources/Public/Icons/ThemeSwitcher/theme_30_black_tie.png";s:4:"dbad";s:57:"Resources/Public/Icons/ThemeSwitcher/theme_30_blitzer.png";s:4:"017c";s:59:"Resources/Public/Icons/ThemeSwitcher/theme_30_cupertino.png";s:4:"c9ec";s:59:"Resources/Public/Icons/ThemeSwitcher/theme_30_dark_hive.png";s:4:"a8ba";s:57:"Resources/Public/Icons/ThemeSwitcher/theme_30_dot_luv.png";s:4:"fd86";s:58:"Resources/Public/Icons/ThemeSwitcher/theme_30_eggplant.png";s:4:"8473";s:65:"Resources/Public/Icons/ThemeSwitcher/theme_30_excite_bike (1).png";s:4:"ac66";s:61:"Resources/Public/Icons/ThemeSwitcher/theme_30_excite_bike.png";s:4:"ac66";s:55:"Resources/Public/Icons/ThemeSwitcher/theme_30_flick.png";s:4:"85b1";s:60:"Resources/Public/Icons/ThemeSwitcher/theme_30_hot_sneaks.png";s:4:"5704";s:58:"Resources/Public/Icons/ThemeSwitcher/theme_30_humanity.png";s:4:"ec4c";s:57:"Resources/Public/Icons/ThemeSwitcher/theme_30_le_frog.png";s:4:"9554";s:60:"Resources/Public/Icons/ThemeSwitcher/theme_30_mint_choco.png";s:4:"39cc";s:58:"Resources/Public/Icons/ThemeSwitcher/theme_30_overcast.png";s:4:"eee4";s:64:"Resources/Public/Icons/ThemeSwitcher/theme_30_pepper_grinder.png";s:4:"3d20";s:60:"Resources/Public/Icons/ThemeSwitcher/theme_30_smoothness.png";s:4:"d3d5";s:62:"Resources/Public/Icons/ThemeSwitcher/theme_30_south_street.png";s:4:"83c2";s:60:"Resources/Public/Icons/ThemeSwitcher/theme_30_start_menu.png";s:4:"dcc2";s:55:"Resources/Public/Icons/ThemeSwitcher/theme_30_sunny.png";s:4:"80a7";s:62:"Resources/Public/Icons/ThemeSwitcher/theme_30_swanky_purse.png";s:4:"8609";s:60:"Resources/Public/Icons/ThemeSwitcher/theme_30_trontastic.png";s:4:"3b4f";s:57:"Resources/Public/Icons/ThemeSwitcher/theme_30_ui_dark.png";s:4:"255a";s:58:"Resources/Public/Icons/ThemeSwitcher/theme_30_ui_light.png";s:4:"c0d0";s:57:"Resources/Public/Icons/ThemeSwitcher/theme_30_windoze.png";s:4:"5f51";s:44:"Resources/Public/Javascript/ThemeSwitcher.js";s:4:"ce56";s:38:"Resources/Public/Stylesheet/Common.css";s:4:"f9dd";s:36:"Resources/Public/Stylesheet/Form.css";s:4:"50b6";s:36:"Resources/Public/Stylesheet/List.css";s:4:"d41d";s:36:"Resources/Public/Stylesheet/Show.css";s:4:"d41d";s:40:"Tests/Unit/Domain/Model/FoodItemTest.php";s:4:"7ac4";s:40:"Tests/Unit/Domain/Model/FoodTypeTest.php";s:4:"8820";s:44:"Tests/Unit/Domain/Model/RefrigeratorTest.php";s:4:"33d7";s:14:"doc/manual.sxw";s:4:"9b85";}',
);