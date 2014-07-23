<?php

require_once('common.php');

$consumer=getConsumer();

$auth_request=$consumer->begin(getEndPoint());

if(!$auth_request){
	displayError('FAILED TO CREATE AUTH REQUEST: not a valid OpenID');
}

$ax_request=new Auth_OpenID_AX_FetchRequest();

foreach($ax_attributes as $id=> $data){
	$attr=new Auth_OpenID_AX_AttrInfo($data['scheme'], 1, $data['required'], $id);
	$ax_request->add($attr);
}

$auth_request->addExtension($ax_request);

$pape_request=new Auth_OpenID_PAPE_Request($pape_policy_uris);
$auth_request->addExtension($pape_request);

$trust_root=trim(getTrustRoot(),'/').'/';

if($auth_request->shouldSendRedirect()){
	$redirect_url=$auth_request->redirectURL($trust_root, getReturnTo());

	if(Auth_OpenID::isFailure($redirect_url)){
		displayError('Could not redirect to server: '.$redirect_url->message);
	}

	ob_end_clean();

	header('Location: '.$redirect_url);
}
else{
	$form_html=$auth_request->htmlMarkup(
					$trust_root,
					getReturnTo(),
					false,
					array('id'=>'mojeid_form')
					);

	if(Auth_OpenID::isFailure($form_html)){
		displayError('Could not redirect to server: '.$form_html->message);
	}

	ob_end_clean();

	echo $form_html;
}

exit(0);
