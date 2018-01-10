<?php
if (!defined('TYPO3_MODE')) {
	die('Access denied.');
}

if (TYPO3_MODE === 'BE') {

	/**
	 * Registers a Backend Module
	 */
	\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerModule(
		'LayoutEditor.' . $_EXTKEY,
		'tools',	 // Make module a submodule of 'tools'
		'admin',	// Submodule key
		'',						// Position
		array(
			'Admin' => 'index',
			
		),
		array(
			'access' => 'user,group',
			'icon'   => 'EXT:' . $_EXTKEY . '/ext_icon.png',
			'labels' => 'LLL:EXT:' . $_EXTKEY . '/Resources/Private/Language/locallang_admin.xlf',
		)
	);

}

$sql = "SELECT uid, name, class, sorting FROM tx_layouteditor_domain_model_layouts_content WHERE deleted='0' AND hidden='0' ORDER BY sorting ASC";
$rs = $GLOBALS['TYPO3_DB']->sql_query($sql);
while ( $out = $GLOBALS['TYPO3_DB']->sql_fetch_assoc($rs)){ 
	$id = $out['uid'];
	\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPageTSConfig( 'TCEFORM.tt_content.layout.addItems.'.$id.' = '.$out['name'] );
	\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTypoScript($_EXTKEY,'setup','
		tt_content.stdWrap.innerWrap.cObject.'.$id.'=TEXT
		tt_content.stdWrap.innerWrap.cObject.'.$id.'.value = <div class="'.$out['class'].'">|</div>');
}
$sql = "SELECT uid, name, class, sorting FROM tx_layouteditor_domain_model_layouts_frontend WHERE deleted='0' AND hidden='0' ORDER BY sorting ASC";
$rs = $GLOBALS['TYPO3_DB']->sql_query($sql);
while ( $out = $GLOBALS['TYPO3_DB']->sql_fetch_assoc($rs)){ 
	$id = $out['uid'];
	\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPageTSConfig( 'TCEFORM.pages.layout.addItems.'.$id.' = '.$out['name'] );
	\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTypoScript($_EXTKEY,'setup','
		page.bodyTagCObject.'.$id.' = TEXT
		page.bodyTagCObject.'.$id.'.wrap = <body class="|">
		page.bodyTagCObject.'.$id.'.value = '.$out['class']);
}
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile($_EXTKEY, 'Configuration/TypoScript', 'Layout Editor');

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_layouteditor_domain_model_admin', 'EXT:layout_editor/Resources/Private/Language/locallang_csh_tx_layouteditor_domain_model_admin.xlf');
// \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_layouteditor_domain_model_admin');



\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPageTSConfig( '<INCLUDE_TYPOSCRIPT: source="FILE:fileadmin/ts/layoutEditor/PageTS/temp.txt">' );

//\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTypoScript($_EXTKEY, 'setup', ' ');