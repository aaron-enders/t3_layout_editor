<?php
if (!defined ('TYPO3_MODE')) {
	die ('Access denied.');
}
$GLOBALS['TCA']['tx_layouteditor_domain_model_layouts_frontend'] = array(
	'ctrl' => array(
		'title'	=> 'LLL:EXT:layout_editor/Resources/Private/Language/locallang.xlf:frontendLayouts',
		'label' => 'name',
		'label_alt' => 'variant',
        'label_alt_force' => 1,
		'tstamp' => 'tstamp',
		'crdate' => 'crdate',
		'cruser_id' => 'cruser_id',
		'dividers2tabs' => TRUE,
		'delete' => 'deleted',
		'sortby' => 'sorting',
		'rootLevel' => 1,
		'enablecolumns' => array(
			'disabled' => 'hidden',
		),
		'searchFields' => 'name,class',
		'iconfile' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extRelPath("layout_editor") . 'ext_icon.png'
	),
	'interface' => array(
		'showRecordFieldList' => 'name, class',
	),
	'types' => array(
		'1' => array('showitem' => 'name, class, references'),
	),
	'columns' => array(
		'hidden' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.hidden',
			'config' => array(
				'type' => 'check',
			),
		),
		'name' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:layout_editor/Resources/Private/Language/locallang.xlf:layoutName',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim'
			),
		),
		'class' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:layout_editor/Resources/Private/Language/locallang.xlf:classPlaceholder',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim'
			),
		),
		'references' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:layout_editor/Resources/Private/Language/locallang.xlf:usedInElements',
			'config' => array(
				'type' => 'inline',
				'readOnly' => 1,
				'foreign_table' => 'pages',
				'foreign_field' => 'layout',
				'appearance' => [
			        'enabledControls' => [
			            'info' => TRUE,
			            'new' => FALSE,
			            'dragdrop' => FALSE,
			            'sort' => FALSE,
			            'hide' => FALSE,
			            'delete' => FALSE,
			            'localize' => FALSE,
			        ],
			    ],
			),
		),
	
	),
);





