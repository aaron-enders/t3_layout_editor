<?php
if (!defined ('TYPO3_MODE')) {
	die ('Access denied.');
}
$GLOBALS['TCA']['tx_layouteditor_domain_model_layouts_powermail'] = array(
	'ctrl' => array(
		'title'	=> 'LLL:EXT:layout_editor/Resources/Private/Language/locallang.xlf:powermailLayouts',
		'label' => 'name',
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
		'showRecordFieldList' => 'name, class, type',
	),
	'types' => array(
		'1' => array('showitem' => 'type, name, class, refs'),
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
		'type' => array (
	        'exclude' => 0,
	        'label' => 'Typ',
	        'config' => array (
                'type' => 'select',
                'items' => array (
                	array('Formular', 'form'),
                    array('Seite', 'page'),
                    array('Feld', 'field') 
                ),
                'size' => 1,
                'maxitems' => 1,
	        )
		),
		'refs' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:layout_editor/Resources/Private/Language/locallang.xlf:usedInElements',
			'config' => array(
				'type' => 'inline',
				'readOnly' => 1,
				'foreign_table' => 'tt_content',
				'foreign_field' => 'layout',
				'appearance' => [
			        'enabledControls' => [
			            'info' => TRUE,
			            'new' => FALSE,
			            'dragdrop' => TRUE,
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





