<?php

/***************************************************************
 * Extension Manager/Repository config file for ext: "layout_editor"
 *
 * Auto generated by Extension Builder 2017-05-05
 *
 * Manual updates:
 * Only the data in the array - anything else is removed by next write.
 * "version" and "dependencies" must not be touched!
 ***************************************************************/

$EM_CONF[$_EXTKEY] = array(
	'title' => 'Layout Editor',
	'description' => 'Configure content elements and frontend layouts without Typoscript. Simply add a layout and your configured class will be ready for use with css.',
	'category' => 'module',
	'author' => 'Aaron Enders',
	'author_email' => 'mail@aaron-enders.de',
	'state' => 'beta',
	'internal' => '',
	'uploadfolder' => '1',
	'createDirs' => 'uploads/tx_layouteditor/PageTS,uploads/tx_layouteditor/TypoScript',
	'clearCacheOnLoad' => 0,
	'version' => '0.9.4',
	'constraints' => array(
		'depends' => array(
			'typo3' => '6.2.0-8.7.1',
		),
		'conflicts' => array(
		),
		'suggests' => array(
		),
	),
);