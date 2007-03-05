<?php
/***************************************************************
*  Copyright notice
*
*  (c)  2007 Ingo Renner <typo3@ingo-renner.com>  
* 
*  All  rights reserved
*
*  This script is part of the TYPO3 project. The TYPO3 project is
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

	// Defining circumstances for CLI mode:
define('TYPO3_cliMode', true);
	// Defining PATH_thisScript here: Must be the ABSOLUTE path of this script in the right 
	// This will work as long as the script is called by it's absolute path!
define('PATH_thisScript', $_SERVER['argv'][0]);

	// Change working directory to the directory of the script.
chdir( dirname( PATH_thisScript ) );


$dirNameThisScript = dirname(PATH_thisScript);

	// Include configuration file: 
require($dirNameThisScript.'/conf.php');
	// Include init file: 
require($dirNameThisScript.'/'.$BACK_PATH.'init.php');


//--------##### Here you run your application! #####--------// 

define('PATH_scripts', $dirNameThisScript.'/../scripts');
require($dirNameThisScript.'/class.tx_scripts_scriptmanager.php');

$scriptManager = t3lib_div::makeInstance('tx_scripts_scriptManager');


if(empty($_SERVER['argv'][1])) {
	echo 'Usage: run_script.php script_to_run [--help]'.chr(10);
	echo '--------------------------------------------'.chr(10).chr(10);
	
	echo $scriptManager->getScriptList();
} else {
	$script   = $_SERVER['argv'][1];
	$filePath = $scriptManager->getScriptFilePath($script);
	
	if(is_file($filePath)) {
		$scriptObj = $scriptManager->getScriptObject($script);
		
		if($_SERVER['argv'][2] == '--help') {
			echo $scriptObj->getUsage();
		} else {
			$scriptObj->main();
		}		
		
	} else {
		echo 'no such script \''.$script.'\''.chr(10);
		echo $scriptManager->getScriptList();
	}
}


?>