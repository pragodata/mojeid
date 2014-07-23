<?php
function xmldb_auth_mojeid_install() {
	/* @var $DB moodle_database */
	global $CFG, $DB;

	$record=$DB->get_record('config', array('name'=>'additionalhtmlhead'));
	$string='<meta http-equiv="x-xrds-location" content="'.$CFG->wwwroot.'/auth/mojeid/api/xrds.php" />';
	if(strpos($record->value, $string)===false){
		$record->value.=$string;
		$DB->update_record('config', $record);
	}
}

