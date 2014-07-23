<?php
require_once('common.php');

$_SESSION['mojeid']['values']=array();

ob_start();

$consumer=getConsumer();

$return_to=getReturnTo();
$response=$consumer->complete($return_to);
$_SESSION['mojeid']=array();
$_SESSION['mojeid']['message']=false;
$_SESSION['mojeid']['success']=false;

if($response->status == Auth_OpenID_CANCEL){
	$_SESSION['mojeid']['message']=get_string('verification_cancelled', 'auth_mojeid');
}
elseif($response->status == Auth_OpenID_FAILURE){
	$_SESSION['mojeid']['message']=get_string('verification_failed', 'auth_mojeid')." ".$response->message;
}
elseif($response->status == Auth_OpenID_SUCCESS){
	$openid_identity=(isset($response->endpoint->claimed_id) ? $response->endpoint->claimed_id : $response->getDisplayIdentifier());

	$_SESSION['mojeid']['success']=sprintf('You have successfully verified '.
					'<a href="%s">%s</a> as your identity.', $esc_identity, $esc_identity);

	$ax_resp=Auth_OpenID_AX_FetchResponse::fromSuccessResponse($response);

	if($ax_resp){
		foreach($ax_attributes as $key=> $value){
			$_SESSION['mojeid']['values'][$key]=(isset($ax_resp->data[$value['scheme']]) ? $ax_resp->data[$value['scheme']] : '');
		}
	}
}

ob_end_clean();

global $CFG;
header('location:'.$CFG->wwwroot.'/login/index.php');
exit();