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


class tx_scripts_update_sys_domain {
	
	var $verbose = false;
	
	function main() {
		if($_SERVER['argv'][2] == '-v') {
			$this->verbose = true;
		}
		
		$this->doUpdate();
	}
	
	function getDescription() {
		return 'updates domain records from .de to .loc';
	}
	
	function getUsage() {
		$usage  = 'update_sys_domain [-v]'.chr(10);
		$usage .= $this->getDescription().chr(10).chr(10);
		$usage .= 'Options are as follows:'.chr(10);		
		$usage .= '-v      Cause update_sys_domain to be verbose'.chr(10);
		
		return $usage;
	}
	
	function doUpdate() {
		$domainRecords = $GLOBALS['TYPO3_DB']->exec_SELECTgetRows(
			'uid, domainName, redirectTo',
			'sys_domain',
			''
		);
		
		foreach($domainRecords as $domainRecord) {
			$newDomainName = str_replace('.de', '.loc', $domainRecord['domainName']);
			$newRedirectTo = str_replace('.de', '.loc', $domainRecord['redirectTo']);
			
			$updateFields = array(
				'domainName' => $newDomainName,
				'redirectTo' => $newRedirectTo
			);
			
			$res = $GLOBALS['TYPO3_DB']->exec_UPDATEquery(
				'sys_domain',
				'uid = '.$domainRecord['uid'],
				$updateFields
			);
			
			if($this->verbose) {
				if($GLOBALS['TYPO3_DB']->sql_affected_rows($res) == 1) {
					echo 'update uid['.$domainRecord['uid'].'] domainName: '
						.$domainRecord['domainName'].' => '.$newDomainName;
						
					if($domainRecord['redirectTo']) {
						echo ' , redirectTo: '
						.$domainRecord['redirectTo'].' => '.$newRedirectTo;
					}
					
					echo chr(10);						
				} else {
					echo 'update failed for uid['.$domainRecord['uid'].']'.chr(10);
				}
			}			
		}
	}
}


if (defined('TYPO3_MODE') && $TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/scripts/scripts/update_sys_domain/class.tx_scripts_update_sys_domain.php']) {
	include_once($TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/scripts/scripts/update_sys_domain/class.tx_scripts_update_sys_domain.php']);
}

?>