<?php

// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * @package auth_mojeid
 * @author Pragodata  {@link http://pragodata.cz}; Vlahovic
 * @license http://www.gnu.org/copyleft/gpl.html GNU Public License
 */
defined('MOODLE_INTERNAL') || die();

require_once($CFG->libdir.'/authlib.php');
require_once($CFG->dirroot.'/user/lib.php');

/**
 * Plugin for no authentication.
 */
class auth_plugin_mojeid extends auth_plugin_base{
	private $mojeid_user_values;
	private $required_mojeid_user_values=array('firstname','lastname','email');
	private $optional_params=array('city'=>'h_city','country'=>'h_country','icq'=>'icq','skype'=>'skype','phone1'=>'phone','phone2'=>'phone_mobile','url'=>'url',);
	private $address_params=array('h_address','h_city','h_postcode','h_state',);
	private $verification_levels=array(
			'pin1_pin2'=>'CONDITIONALLY_IDENTIFIED',
			'pin3'=>'IDENTIFIED',
			'validation'=>'VALIDATED',
			'validation_adult_control'=>'VALIDATED');
	/* @var $db moodle_database */
	private $db;
	private $user_record;

	public function __construct(){
		global $DB;
		$this->authtype='mojeid';
		$this->config=get_config('auth/mojeid');
		if(empty($this->config->verification_level)){
			$this->config->verification_level='pin1_pin2';
		}
		$this->setDb($DB);
	}

	private function setDb(moodle_database $db){
		$this->db=$db;
		return $this;
	}

	public function loginpage_hook(){
		parent::loginpage_hook();
		global $show_instructions, $CFG;
		$show_instructions=true;
		$verification_finish=$this->verificationFinish();
		$CFG->auth_instructions=$this->printMojeidForm($verification_finish).$CFG->auth_instructions;
	}

	/**
	 * Returns true if the username and password work or don't exist and false
	 * if the user exists and the password is wrong.
	 *
	 * @param string $username The username
	 * @param string $password The password
	 * @return bool Authentication success or failure.
	 */
	function user_login($username, $password){
		global $CFG, $DB;
		if($user=$DB->get_record('user', array(
				'username'=>$username,
				'mnethostid'=>$CFG->mnet_localhost_id))){
			return validate_internal_user_password($user, $password);
		}
		return true;
	}

	/**
	 * Updates the user's password.
	 *
	 * called when the user password is updated.
	 *
	 * @param  object  $user        User table object
	 * @param  string  $newpassword Plaintext password
	 * @return boolean result
	 *
	 */
	function user_update_password($user, $newpassword){
		$user=get_complete_user_data('id', $user->id);
		// This will also update the stored hash to the latest algorithm
		// if the existing hash is using an out-of-date algorithm (or the
		// legacy md5 algorithm).
		return update_internal_user_password($user, $newpassword);
	}

	function prevent_local_passwords(){
		return false;
	}

	/**
	 * Returns true if this authentication plugin is 'internal'.
	 *
	 * @return bool
	 */
	function is_internal(){
		return true;
	}

	/**
	 * Returns true if this authentication plugin can change the user's
	 * password.
	 *
	 * @return bool
	 */
	function can_change_password(){
		return true;
	}

	/**
	 * Returns the URL for changing the user's pw, or empty if the default can
	 * be used.
	 *
	 * @return moodle_url
	 */
	function change_password_url(){
		return null;
	}

	/**
	 * Returns true if plugin allows resetting of internal password.
	 *
	 * @return bool
	 */
	function can_reset_password(){
		return true;
	}

	/**
	 * Prints a form for configuring this authentication plugin.
	 *
	 * This function is called from admin/auth.php, and outputs a full page with
	 * a form for configuring this plugin.
	 *
	 * @param array $page An object containing all the data for this page.
	 */
	function config_form($config, $err, $user_fields){
		include "config.html";
	}

	/**
	 * Processes and stores configuration data for this authentication plugin.
	 */
	function process_config($config){
		set_config('security_level', $config->security_level, 'auth/mojeid');
		set_config('verification_level', (string)$config->verification_level, 'auth/mojeid');
		set_config('why_mojeid_url', (string)$config->why_mojeid_url, 'auth/mojeid');
		set_config('login_mojeid_url', (string)$config->login_mojeid_url, 'auth/mojeid');
		return true;
	}

	/* ************************************************************************ */

	private function printMojeidForm($verification_finish=null){
		/* @var $PAGE moodle_page */
		global $CFG, $PAGE;
		$url=($this->config->why_mojeid_url ? $this->config->why_mojeid_url : 'http://www.mojeid.cz/page/805/vyhody-mojeid/');
		require_once($CFG->dirroot.'/auth/mojeid/api/common.php');
		$PAGE->requires->js_init_code('M.cfg.mojeid_lang_create="'.get_string('create', 'auth_mojeid').'";');
		$PAGE->requires->js_init_code('M.cfg.mojeid_end_point="'.getEndPoint('registration/endpoint').'";');
		$PAGE->requires->js('/auth/mojeid/js/jquery-1.11.1.min.js');
		$PAGE->requires->js('/auth/mojeid/js/mojeid.js');
		$PAGE->requires->css('/auth/mojeid/css/mojeid.css');
		$image_url=($this->config->login_mojeid_url ? $this->config->login_mojeid_url : $CFG->wwwroot.'/auth/mojeid/api/image/155x24.png');
		$return='
<div id="wrapper" class="mojeid_login_box">
		<strong>'.$verification_finish.'</strong>
    <div class="form">
      <a href="'.$CFG->wwwroot.'/auth/mojeid/api/auth.php"><img src="'.$image_url.'" alt="'.get_string('sign_in_with', 'auth_mojeid').'"></a>
		</div>
	  <div class="links">
	    <span id="why"><a href="'.$url.'">'.get_string('why', 'auth_mojeid').'</a></span>
	  </div>
</div>
			';
		return $return;
	}

	private function verificationFinish(){
		$return=false;
		$mojeid=(!empty($_SESSION['mojeid']) ? $_SESSION['mojeid'] : false);
		if(!empty($mojeid)){
			if(!empty($mojeid['message'])){
				$return=$mojeid['message'];
			}
			elseif(!empty($mojeid['values'])){
				try{
					$this
									->setMojeidUserValues($mojeid['values'])
									->verificationLevelControl()
									->adultControl()
									->login()
									->isEmailAvailable()
									->createUser()
									->login()
									;
					$return=get_string('unknown_error_during_login_user','auth_mojeid');
				}
				catch(Exception $exc){
					$return=$exc->getMessage();
				}
			}
			else{
				$return=get_string('unknown_error_during_communication_with_mojeid','auth_mojeid');
			}
		}
		unset($_SESSION['mojeid']);
		return $return;
	}

	private function verificationLevelControl(){
		$user_level=false;
		$min_level=false;
		$verificated=false;
		foreach($this->verification_levels as $level => $status){
			if($level===$this->config->verification_level ){
				$min_level=true;
			}
			if($min_level && $this->mojeid_user_values['status']===$status){
				$verificated=true;
			}
			if($this->mojeid_user_values['status']===$status){
				$user_level=$level;
			}
		}

		if($user_level && !$verificated){
			$msg=get_string('verification_level_control_failed', 'auth_mojeid').'<br>'
					.get_string('your_verification_level_is', 'auth_mojeid').' "'.get_string($user_level,'auth_mojeid').'".<br>'
					.get_string('minimal_verification_level_is', 'auth_mojeid').' "'.get_string($this->config->verification_level,'auth_mojeid').'".';
			throw new Exception($msg);
		}
		return $this;
	}

	private function adultControl(){
		$msg=false;
		if($this->mojeid_user_values['status']){
			$msg=$this->adultControlFullVersion();
		}
		else{
			$msg=$this->adultControlSemiVersion();
		}
		if($msg){
			$msg=get_string('adult_control_failed','auth_mojeid').$msg;
			throw new Exception($msg);
		}
		return $this;
	}

	private function adultControlFullVersion(){
		$return=null;
		if($this->config->verification_level==='validation_adult_control' && ((empty($this->mojeid_user_values['adult']) || $this->mojeid_user_values['adult']==='False') || (empty($this->mojeid_user_values['valid']) || $this->mojeid_user_values['valid']==='False'))){
			if(empty($this->mojeid_user_values['adult']) || $this->mojeid_user_values['adult']==='False'){
				$return='<br/>'.get_string('you_are_not_adult','auth_mojeid');
			}
			if(empty($this->mojeid_user_values['valid']) || $this->mojeid_user_values['valid']==='False'){
				$return='<br/>'.get_string('your_account_is_not_valid','auth_mojeid');
			}
		}
		return $return;
	}

	private function adultControlSemiVersion(){
		$return=null;
		if($this->config->verification_level==='validation_adult_control' && (empty($this->mojeid_user_values['adult']) || $this->mojeid_user_values['adult']==='False')){
			$return='<br/>'.get_string('you_are_not_adult','auth_mojeid');
		}
		return $return;
	}

	private function isEmailAvailable(){
		$record=$this->db->get_record('user',array('email'=>$this->mojeid_user_values['email']));
		if($record && $record->auth!=$this->authtype){
			throw new Exception(get_string('email_already_used','auth_mojeid'));
		}
		return $this;
	}

	private function login(){
		$record=$this->db->get_record('user',array('auth'=>$this->authtype, 'email'=>$this->mojeid_user_values['email']));
		if($record){
			$this
							->updateUser($record)
							->sessionSetUser();
		}
		return $this;
	}

	private function setUserRecord(stdClass $user_record){
		$this->user_record=$user_record;
		return $this;
	}

	private function updateUser(stdClass $actual_data){
		if($actual_data){
			$user_data=$this->printUserData();
			$user_data->username=$actual_data->username;
			$user_data->id=$actual_data->id;
			$this->setUserRecord($user_data);
			user_update_user($user_data);
		}
		return $this;
	}

	private function sessionSetUser(){
		global $CFG;
		session_set_user($this->user_record);
		header('location:'.$CFG->wwwroot);
		exit();
	}

	private function setMojeidUserValues($mojeid_user_values){
		$arr=array();
		$no_data=array();
		foreach($mojeid_user_values as $value_name => $value_data){
			$arr[$value_name]=reset($value_data);
		}
		foreach($this->required_mojeid_user_values as $value_name){
			if(empty($arr[$value_name])){
				$no_data[]=$value_name;
			}
		}
		if(empty($no_data)){
			$this->mojeid_user_values=$arr;
		}
		else{
			throw new Exception(get_string('not_exists_mojeid_user_data','auth_mojeid').' ('.implode(', ', $no_data).')');
		}
		return $this;
	}

	private function createUser(){
		try{
			user_create_user($this->printUserData());
		}
		catch(Exception $exc){
			throw new Exception(get_string('unknown_error_during_create_user','auth_mojeid').' ('.$exc->getMessage().')');
		}
		return $this;
	}

	/**
	 * @return stdClass
	 */
	private function printUserData(){
		global $CFG;
		$user_data=$this->printMojeIdUserData();
		$user_data['username']=strtolower($this->mojeid_user_values['email']);
		$user_data['password']='Wok3#'.md5(time());
		$user_data['auth']=$this->authtype;
		$user_data['confirmed']=true;
		$user_data['mnethostid']=$CFG->mnet_localhost_id;
		return (object)$user_data;
	}

	private function printMojeIdUserData(){
		$return=array(
				'firstname'=>$this->mojeid_user_values['firstname'],
				'lastname'=>$this->mojeid_user_values['lastname'],
				'email'=>$this->mojeid_user_values['email'],
		);
		$address=array();
		foreach($this->address_params as $param){
			if(!empty($this->mojeid_user_values[$param])){
				$address[]=$this->mojeid_user_values[$param];
			}
		}
		if(!empty($address)){
			$return['address']=implode(', ',$address);
		}
		// nastavi nepovinne
		foreach($this->optional_params as $moodle_param => $mojeid_param){
			if(!empty($this->mojeid_user_values[$mojeid_param])){
				$return[$moodle_param]=$this->mojeid_user_values[$mojeid_param];
			}
		}

		return $return;
	}
}