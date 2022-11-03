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
}
