<?php
/***************************************************************
*  Copyright notice
*
*  (c)  2007 Ingo Renner <typo3@ingo-renner.com>
*  All rights reserved
*
*  This script is part of the Typo3 project. The Typo3 project is
*  free software; you can redistribute it and/or modify
*  it under the terms of the GNU General Public License as published by
*  the Free Software Foundation; either version 2 of the License, or
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
 * script manager class to handle inclusion and instantiation of scripts
 * 
 * @author Ingo Renner
 * @package TYPO3
 * @subpackage tx_scripts
 */
class tx_scripts_scriptManager {
	
	/**
	 * instantiates a script object and returns it
	 * 
	 * @param string $scriptName: script name
	 * @return object instance of the required script
	 */
	function &getScriptObject($scriptName) {
		require_once($this->getScriptFilePath($scriptName));
		
		return t3lib_div::makeInstance('tx_scripts_'.$scriptName);
	}
	
	/**
	 * creates the path to a script file
	 * 
	 * @param string $scriptName: script name
	 * @return string path to the script file
	 */
	function getScriptFilePath($scriptName) {
		return PATH_scripts.'/'.$scriptName.'/class.tx_scripts_'.$scriptName.'.php';
	}
	
	/**
	 * creates a list of available scripts
	 * 
	 * @return string formated and printable list of scripts
	 */
	function getScriptList() {
		$scripts = t3lib_div::get_dirs(PATH_scripts);
		
		$scriptList  = 'available scripts:'.chr(10);
		$scriptList .= '--------------------------------------------'.chr(10);
		
		foreach($scripts as $script) {
			$scriptObj   = $this->getScriptObject($script);		
			$scriptList .= $script.': '.$scriptObj->getDescription().chr(10);
		}
		
		return $scriptList;
	}
}


if (defined('TYPO3_MODE') && $TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/scripts/cli/class.tx_scripts_scriptmanager.php']) {
	include_once($TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/scripts/cli/class.tx_scripts_scriptmanager.php']);
}

?>