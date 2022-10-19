<?php
namespace Tenant\Satrix\Controller\Api;


use Magento\Framework\Controller\ResultFactory;

abstract class BaseApi extends \Magento\Framework\App\Action\Action
{
	public function __construct(\Magento\Framework\App\Action\Context $context
		
	 ){
        parent::__construct($context);
	    $token = $this->getRequest()->getHeader('token');
		if(!$token || $token == "") {
			
			$resultJson = $this->resultFactory->create(ResultFactory::TYPE_JSON);
			$response = array();
			$response['status'] = "error";
			$response['message'] = "UnAuthorize";
			$resultJson->setData($response);
			echo json_encode($response);exit;
		}
    }
	
		public function getBodyParams() {
			
			$data = $this->getRequest()->getContent();
			$data = json_decode($data, true);
			return $data;
		}
}
