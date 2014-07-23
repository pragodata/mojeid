$(window).ready(function(){
	new Mojeid(M.cfg.mojeid_end_point, M.cfg.wwwroot, M.cfg.mojeid_lang_create).init();
});

function Mojeid(_end_point, _wwwroot, _create){
	var self=this;
	
	var end_point=_end_point;
	var www_root=_wwwroot;
	var create=_create;

	var login_box=$('div.mojeid_login_box');
	var links_box=login_box.children('div.links');
	var registration_nonce='d7abe8cdfba8ebcce5092dbe31a49e0b';

	this.init=function(){
		appendForm();
		bindSubmitAction();
		return self;
	};

	var appendForm=function(){
		var link=' | <span id="register"><a href="#">'+create+'</a></span>';
		links_box.append(link);
		links_box.find('a').attr('target','_blank');
	  var form='<form action="'+end_point+'" method="post" enctype="multipart/form-data" id="register-form" target="_blank">'+
			'<input type="hidden" name="realm" value="'+www_root+'" />'+
	    '<input type="hidden" name="registration_nonce" value="'+registration_nonce+'" />'+
			'</form>';
		login_box.append(form);
	};

	var bindSubmitAction=function(){
		links_box.children('span#register').children('a').click(function(event){
			event.preventDefault();
			event.stopPropagation();
			$('form#register-form').submit();
		});
	};

	return self;
}

