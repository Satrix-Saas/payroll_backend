<?php
namespace Tenant\Satrix\Controller\Api;

use Magento\Framework\Controller\ResultFactory;

abstract class BaseApi extends \Magento\Framework\App\Action\Action
{
    public function __construct(
	\Magento\Framework\App\Action\Context $context
	)
    {
        parent::__construct($context);
		
        $token = $this->getRequest()->getHeader("token");
		// echo $token;exit;
        if (!$token || $token == "") {
            $resultJson = $this->resultFactory->create(
                ResultFactory::TYPE_JSON
            );
            $response = [];
            $response["status"] = "error";
            $response["message"] = "UnAuthorize";
            $resultJson->setData($response);
            echo json_encode($response);
            // exit();
        }
    }

    public function getBodyParams()
    {
		$data= $this->getRequest()->getPost();
        $count = count($data);
        if($count>0){
            $data = json_decode($data['data'], true);
        }else{
            $data = $this->getRequest()->getContent();
            $data = json_decode($data, true);
        }
        // echo"<pre>";print_r($data);exit;
        // exit("12332");
        // $data = $this->getRequest()->getContent();
       // $data = json_decode($data['data'], true);
        // echo"<pre>";print_r($data);exit;

        return $data;
    }

    public function getResponseArray()
    {
        $response_array = array();
        $resonse_array['ResponseCode'] =['true' => 1,'false' => 0]; 
        $resonse_array['register'] = ['true' => 'Registration Successfully','false' => 'User all ready registered'];
        $resonse_array['login'] = ['true' => 'login Successfully','false' => 'Incorrect Email or Password'];
        $resonse_array['reset'] = ['true' => 'Password Updated Successfully','false' => 'Password Updated UnSuccessfully'];
        $resonse_array['dbexception'] = "db_exception";
        $resonse_array['leave'] = ['true' => 'Leave Updated Succesfully','false' => 'leave Not Updated'];
        $resonse_array['attendance'] = ['true' => 'Registration Successfully','false' => 'User all ready registered'];
        $resonse_array['holiday'] = ['true' => 'Registration Successfully','false' => 'User all ready registered'];
        $resonse_array['department'] = ['true' => 'Registration Successfully','false' => 'User all ready registered'];
        $resonse_array['company'] = ['true' => 'Registration Successfully','false' => 'User all ready registered'];
        return $resonse_array;
    }
}
