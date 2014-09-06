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
		)
	));