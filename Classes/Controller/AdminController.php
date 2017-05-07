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
		$tempConfigPathOriginal = PATH_site . "/typo3conf/ext/layout_editor/Configuration/";
		$tempConfigPath = PATH_site . "/uploads/tx_layouteditor/";

		$args = $this->request->getArguments();

		//After saving Content Layouts:
		if ($contentLayouts = $args['contentLayouts']){
			$tsConfigFile = fopen($tempConfigPath.'/PageTS/temp.txt', "w");
			$tsFile = fopen($tempConfigPath.'/TypoScript/temp.txt', "w");
			foreach ($contentLayouts as $index => $contentLayout){
				$tsConfig = '#'.$contentLayout['class'].'
TCEFORM.tt_content.layout.addItems.'.$contentLayout['number'].' = '.$contentLayout['label'].'
';
				$ts = 'tt_content.stdWrap.innerWrap.cObject.'.$contentLayout['number'].'=TEXT
tt_content.stdWrap.innerWrap.cObject.'.$contentLayout['number'].'.value = <div class="'.$contentLayout['class'].'">|</div>
';
				fwrite($tsConfigFile, $tsConfig)  or die('fwrite failed');
				fwrite($tsFile, $ts)  or die('fwrite failed');
			}
			fclose($tsConfigFile);
			fclose($tsFile);
			
		}

/* -------------------------------------------------------------------------------------------------------------------- */
	// Read Current Settings //	
/* -------------------------------------------------------------------------------------------------------------------- */
		$contentLayouts = array();
		$tsConfigFile = ($tempConfigPath.'/PageTS/temp.txt');
		$tsFile = ($tempConfigPath.'/TypoScript/temp.txt');
		$tsMainFile = ($tempConfigPathOriginal.'/TypoScript/main.txt');

		$tsConfigHandle = fopen($tsConfigFile, "r");
		if (FALSE === $tsConfigHandle) {
			//Create needed files:
			if (!file_exists($tempConfigPath)) {
			    mkdir($tempConfigPath, 0777, true);
			    mkdir($tempConfigPath.'/PageTS', 0777, true);
			    mkdir($tempConfigPath.'/TypoScript', 0777, true);
			}

			if (!file_exists($tempConfigPath .'/PageTS/temp.txt')){
				
			    if (!copy($tempConfigPathOriginal.'/PageTS/temp.txt', $tempConfigPath .'/PageTS/temp.txt')){
			    	echo "<br>Copy failed<br>";
			    }
			}

			if (!file_exists($tempConfigPath .'/TypoScript/temp.txt')){
				if (!copy($tempConfigPathOriginal.'/TypoScript/temp.txt', $tempConfigPath .'/TypoScript/temp.txt')){
			    	"Copy failed";
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
					$split = explode("#",$line);
					$class = trim(preg_replace('/\s\s+/', ' ', $split[1]));
				}else{
					$config = explode("addItems.",$line)[1];
					$label = trim(explode(" = ",$config)[1]);
					$number = explode(" = ",$config)[0];

					$contentLayouts[$number]["class"] = $class;
					$contentLayouts[$number]["label"] = $label;
				}
				
		  }
		  
		  
		}
		fclose($tsConfigHandle);
		$this->view->assign('tsFile', nl2br(htmlentities(file_get_contents($tsFile, true))));
		$this->view->assign('tsConfigFile', nl2br(htmlentities(file_get_contents($tsConfigFile, true))));
		$this->view->assign('tsMainFile', nl2br(htmlentities(file_get_contents($tsMainFile, true))));
		$this->view->assign('contentLayouts', $contentLayouts);
	}

}