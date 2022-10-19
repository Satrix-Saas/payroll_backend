<?php
namespace Tenant\Employee\Controller\Index;


use Magento\Framework\Controller\ResultFactory;

class Index extends \Tenant\Satrix\Controller\Api\BaseApi
{
	protected $_pageFactory;
    protected $resultPageFactory;

	public function __construct(
		\Magento\Framework\App\Action\Context $context,
		 \Tenant\Satrix\Helper\Data $helper,
		 \Magento\Framework\View\Result\PageFactory $pageFactory
         )
	{
		$this->helper = $helper;
		parent::__construct($context);
	}

		
	public function execute()
    { 
		 $data = $this->getBodyParams();
		 $response = ['success' => false];
		 if(!empty($data)){
			 
			 $returnArray = $this->helper->requiredFields($data , true , 'register');
			 if($returnArray['status'] != "error"){
				$response = ['success' => true, 'message' => $returnArray];
				echo json_encode(array('response' => $response));
			 }else{
				$response = ['success' => false, 'message' => $returnArray];
				echo json_encode(array('response' => $response));
			 }
		 }else{
			 echo json_encode(array('response' => $response));
		 }
	}

	
	 
}
