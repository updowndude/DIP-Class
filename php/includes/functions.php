<?php

// copyright 2017 DipFestival, LLC
//validate form data to prevent injections
	function validateFormData($formData){
		$formData=trim(stripslashes(htmlspecialchars(strip_tags(str_replace(array('(',')'),'',$formData)),ENT_QUOTES)));
    	return $formData;
	}

	//domain referer
	function request_is_same_domain(){
		if(!isset($_SERVER['HTTP_REFERER'])){
			//can't be same domain, no referer sent
			return false;
		}else{
			$referer_host=parse_url($_SERVER['HTTP_REFERER'],PHP_URL_HOST);
			$server_host=$_SERVER['HTTP_HOST'];
			
			return ($referer_host==$server_host)?true:false;
		}//if()
	}//function()

	//csrf token
	

?>