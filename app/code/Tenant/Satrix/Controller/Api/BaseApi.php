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
		// $data= $this->getRequest()->getPost();
		// echo '<pre>';print_r($data);exit;
        $data = $this->getRequest()->getContent();
        $data = json_decode($data, true);
        return $data;
    }
}
