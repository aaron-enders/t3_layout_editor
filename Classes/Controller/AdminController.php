<?php
namespace LayoutEditor\LayoutEditor\Controller;

/***************************************************************
 *
 *  Copyright notice
 *
 *  (c) 2017 Aaron Enders <mail@aaron-enders.de>, aaron-enders.de
 *
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 3 of the License, or
 *  (at your option) any later version.
 *
 *  The GNU General Public License can be found at
 *  http://www.gnu.org/copyleft/gpl.html.
 *
 *  This script is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  This copyright notice MUST APPEAR in all copies of the script!
 ***************************************************************/

/**
 * AdminController
 */
class AdminController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController {

	/**
	 * action index
	 * 
	 * @return void 
	 */
	public function indexAction() {
		rename(PATH_site.'uploads/tx_layouteditor', PATH_site.'fileadmin/ts/layoutEditor');

		$tempConfigPathOriginal = PATH_site . "typo3conf/ext/layout_editor/Configuration/";
		$tempConfigPath = PATH_site . "fileadmin/ts/layoutEditor/";

		$args = $this->request->getArguments();
		$changes = false;


/* -------------------------------------------------------------------------------------------------------------------- */
	//saving Content Layouts:
/* -------------------------------------------------------------------------------------------------------------------- */
		
		if ($args['sent']){
			$tsConfigFile = fopen($tempConfigPath.'/PageTS/temp.txt', "w");
			$tsFile = fopen($tempConfigPath.'/TypoScript/temp.txt', "w");

			if ($contentLayouts = $args['contentLayouts']){
			
				foreach ($contentLayouts as $index => $contentLayout){
					$tsConfig = '#'.$contentLayout['class'].'
TCEFORM.tt_content.layout.addItems.'.$contentLayout['number'].' = '.$contentLayout['label'].'
';
				$ts = 'tt_content.stdWrap.innerWrap.cObject.'.$contentLayout['number'].'=TEXT
tt_content.stdWrap.innerWrap.cObject.'.$contentLayout['number'].'.value = <div class="'.$contentLayout['class'].'">|</div>
';

// RTE.default.proc.allowedClasses := addToList(btnSolid) 
// RTE.default.buttons.link.properties.class.allowedClasses := addToList(btnSolid) 
// RTE.classesAnchor.btnSolid.name = btnSolid
					fwrite($tsConfigFile, $tsConfig)  or die('fwrite failed');
					fwrite($tsFile, $ts)  or die('fwrite failed');
				}
				
				$changes = true;
			}
			$ts = "";
			$tsConfig = "";
			if ($frontendLayouts = $args['frontendLayouts']){
				foreach ($frontendLayouts as $index => $frontendLayout){
					$tsConfig = '#_frontend_'.$frontendLayout['class'].'
TCEFORM.pages.layout.addItems.'.$frontendLayout['number'].' = '.$frontendLayout['label'].'
';
					$ts = 'page.bodyTagCObject.'.$frontendLayout['number'].' = TEXT
page.bodyTagCObject.'.$frontendLayout['number'].'.wrap = <body class="|">
page.bodyTagCObject.'.$frontendLayout['number'].'.value = '.$frontendLayout['class'].'
';
					fwrite($tsConfigFile, $tsConfig)  or die('fwrite failed');
					fwrite($tsFile, $ts)  or die('fwrite failed');
				}
				$changes = true;
			}
			if ($changes){
				
				$this->addFlashMessage(
				    \TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate("saved", "layout_editor", array()),
				    '',
				    \TYPO3\CMS\Core\Messaging\FlashMessage::OK
				);	
			}
			
			fclose($tsConfigFile);
			fclose($tsFile);
		}
		

/* -------------------------------------------------------------------------------------------------------------------- */
	// Read Current Settings //	
/* -------------------------------------------------------------------------------------------------------------------- */
		$frontendLayouts = array();
		$contentLayouts = array();
		$tsConfigFile = ($tempConfigPath.'/PageTS/temp.txt');
		$tsFile = ($tempConfigPath.'/TypoScript/temp.txt');
		$tsMainFile = ($tempConfigPathOriginal.'/TypoScript/main.txt');

		@$tsConfigHandle = fopen($tsConfigFile, "r");
		if (FALSE === $tsConfigHandle) {
			//Create needed files:
			if (!file_exists($tempConfigPath)) {
			}

			if (!file_exists($tempConfigPath .'PageTS/temp.txt')){
				if (!is_dir($tempConfigPath .'PageTS/')) {
				    if (!mkdir($tempConfigPath .'PageTS/', 0777, true)){
				    	echo "Couldnt create folder.<br>";
						echo $tempConfigPath .'PageTS/';
						die();
				    }

				}
			    if (!copy($tempConfigPathOriginal.'/PageTS/temp.txt', $tempConfigPath .'/PageTS/temp.txt')){
			    	echo "<br>Copy failed<br>";
			    }
			}
			if (!file_exists($tempConfigPath .'TypoScript/temp.txt')){
				if (!is_dir($tempConfigPath .'TypoScript/')) {
				    if(!mkdir($tempConfigPath .'TypoScript/', 0777, true)){
						echo "Couldnt create folder.<br>";
						die();
					}
				}
				
				if (!copy($tempConfigPathOriginal.'/TypoScript/temp.txt', $tempConfigPath .'/TypoScript/temp.txt')){

			    	echo "Copy failed. <br>";
			    	echo "Source: ".$tempConfigPathOriginal.'/TypoScript/temp.txt';
			    	echo "<br>Target: ".$tempConfigPath .'/TypoScript/temp.txt';
			    	die();

			    }
			    
			}
		    //exit("Konnte Stream von URL nicht öffnen");
		    $tsConfigHandle = fopen($tsConfigFile, "r");
		}
		$tsConfig = '';
		//Read tsConfig:
		while (!feof($tsConfigHandle)) {
		  $line = fgets($tsConfigHandle);
		  if (trim($line) != ""){
				if (substr($line, 0, 1) == '#') {
					//if Frontend Layout:
					if (substr( $line, 0, 11 ) == "#_frontend_"){
						$line = str_replace('#_frontend_', '#', $line);
						$type = "frontend";
					}else{
						$type = "content";
					}
					$split = explode("#",$line);
					$class = trim(preg_replace('/\s\s+/', ' ', $split[1]));
				}else{

					$config = explode("addItems.",$line)[1];
					$label = trim(explode(" = ",$config)[1]);
					$number = explode(" = ",$config)[0];
					if ($type == "frontend"){
						$frontendLayouts[$number]["class"] = $class;
						$frontendLayouts[$number]["label"] = $label;
					}else{
						$contentLayouts[$number]["class"] = $class;
						$contentLayouts[$number]["label"] = $label;
					}
					
				}

				
		  }
		  
		  
		}
		fclose($tsConfigHandle);
		$this->view->assign('tsFile', nl2br(htmlentities(file_get_contents($tsFile, true))));
		$this->view->assign('tsConfigFile', nl2br(htmlentities(file_get_contents($tsConfigFile, true))));
		$this->view->assign('tsMainFile', nl2br(htmlentities(file_get_contents($tsMainFile, true))));
		$this->view->assign('contentLayouts', $contentLayouts);
		$this->view->assign('frontendLayouts', $frontendLayouts);
	}

}