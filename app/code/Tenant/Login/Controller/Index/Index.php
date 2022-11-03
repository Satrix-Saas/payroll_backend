<?php
namespace Tenant\Login\Controller\Index;


use Magento\Framework\Controller\ResultFactory;
use Tenant\Registration\Model\PostFactory;
use Tenant\Registration\Model\TokenFactory as token;
use Tenant\Registration\Model\ResourceModel\Post\CollectionFactory;
use Tenant\Registration\Model\ResourceModel\Post\TokenCollectionFactory;

class Index extends \Tenant\Satrix\Controller\Api\BaseApi
{
	protected $_pageFactory;
    protected $resultPageFactory;

	public function __construct(
		\Magento\Framework\App\Action\Context $context,
		\Magento\Framework\View\Result\PageFactory $pageFactory,
		\Tenant\Satrix\Helper\Data $helper,
		\Magento\Framework\App\Request\Http $request,
		CollectionFactory $registrationData,
		TokenCollectionFactory $tokenData,
		PostFactory  $PostFactory,
		token  $TokenFactory
        )
	{
		$this->_request = $request;
		$this->helper = $helper;
		$this->PostFactory = $PostFactory;
		$this->TokenFactory = $TokenFactory;
		$this->registrationData = $registrationData;
		$this->tokenData = $tokenData;
       	return parent::__construct($context);
	}

    public function execute()
    { 
		$resultJson = $this->resultFactory->create(ResultFactory::TYPE_JSON);
		 $data = $this->getBodyParams();
		 $response = ['success' => false];
		if(!empty($data)){
			$returnArray = $this->helper->requiredFields($data , true , 'login');
				 if($returnArray['status'] != "error"){
				 $flag = "";
				    try {
						if (!empty($returnArray)) {
							
							 $user_data = $this->registrationData->create();
							 $user_data = $user_data->getData();

							
							foreach($user_data as $key=>$value){
								if(in_array($returnArray['email'], $value)){
									if($returnArray['password'] === $value['password']){
									$model =  $this->TokenFactory->create()->load($value['reg_id'],'reg_id');
									$model->delete();
									$response = ['success' => true, 'message' => "deleted"];
									$this->helper->createToken($value['reg_id']);
									$response = ['success' => true, 'message' => "Login Successfully"];
									echo json_encode(array('response' => $response));								
								}else{
									$response = ['success' => false, 'message' => "Email or Password are incorrect"];
									echo json_encode(array('response' => $response));
								}
							}
						}
						}
					} catch (\Exception $e) {
						$response = ['success' => false, 'message' => "db exception"];
						$resultJson->setData($response);
						return $resultJson;
					}
			 }else{
				$response = ['success' => false, 'message' => $returnArray];
				$resultJson->setData($response);
				return $resultJson;
			 }
		 }else{
			$resultJson->setData($response);
			return $resultJson;
		 }
	}
	
}
