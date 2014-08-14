<?php
function xmldb_auth_mojeid_upgrade($old_version = 0) {
	/* @var $DB moodle_database */
	global $DB, $CFG;
	$old_version=(int)$old_version;
	$return = true;
	if($old_version < 2014081200){
		try{
			$query="UPDATE {user} SET mnethostid=".$CFG->mnet_localhost_id.", confirmed=1 WHERE auth='mojeid' AND mnethostid=0";
			$DB->execute($query);
		}
		catch(Exception $exc){
			$return=false;
			echo $exc->getTraceAsString();
		}
	}
	return $return;
}