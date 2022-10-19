<?php
namespace Tenant\Satrix\Helper;

use \Magento\Framework\App\Helper\AbstractHelper;

class Data extends AbstractHelper
{
	public function requiredFields($requiredFieldName, $validate_enabled ,$name )
    {
        $response =array();
		
		$validation_field_array = Self::validationFieldsArray($name);
	   
        if($validate_enabled){
			foreach($requiredFieldName as $required_field => $value) {
					if(!isset($validation_field_array[$required_field])){
						$response['status'] = "error";
						$response[$required_field] = "Unknown column " .$required_field;
					}else{
						$response['status'] = "success";
						$response[$required_field] = $value;
					}
				}
				return $response;
		}
		
	}
	
	public function validationFieldsArray($field_array_name){
	  

	 
	   if($field_array_name == 'register'){
			$validation[$field_array_name] = array('username'=>'' , 'org_name' => '' , 'email' => '' , 'contact'=>'' , 'org_size'=>'' ,'type'=>'');
	   }
	   if($field_array_name == 'login'){
			$validation[$field_array_name] = array('email'=>'' , 'password' => '');
	   }
	
		if(isset($validation[$field_array_name])){
	         return  $validation[$field_array_name];   
		}else{
		   return  $validation[$field_array_name] = '';
		}
	   
	}
	 
}
