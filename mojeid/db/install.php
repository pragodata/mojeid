<?php
function xmldb_auth_mojeid_install() {
	global $CFG;

	$config=get_config('core','additionalhtmlhead');
	$string='<meta http-equiv="x-xrds-location" content="'.$CFG->wwwroot.'/auth/mojeid/api/xrds.php" />';
	if(strpos($config, $string)===false){
		$config.=$string;
		set_config('additionalhtmlhead', $config);
	}
}

