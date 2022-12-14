<?php
namespace Tenant\Registration\Controller\Index;


use Magento\Framework\Controller\ResultFactory;
use Tenant\Registration\Model\PostFactory;
use Tenant\Registration\Model\TokenFactory as token;
use Tenant\Registration\Model\ResourceModel\Post\CollectionFactory;
use Tenant\Registration\Model\ResourceModel\Post\TokenCollectionFactory;

class Index extends \Tenant\Satrix\Controller\Api\BaseApi
{
	protected $_pageFactory;
    protected $resultPageFactory;
	protected $_request ;

	public function __construct(
		\Magento\Framework\App\Action\Context $context,
		\Magento\Framework\View\Result\PageFactory $pageFactory,
		\Tenant\Satrix\Helper\Data $helper,
		\Magento\Framework\App\Request\Http $request,
		 CollectionFactory $registrationData,
		 PostFactory  $PostFactory,
		 token  $TokenFactory
         )
	{
		$this->_request = $request;
		$this->helper = $helper;
		$this->PostFactory = $PostFactory;
		$this->TokenFactory = $TokenFactory;
		$this->registrationData = $registrationData;
       	return parent::__construct($context);
	}

   	
	public function execute()
    { 
	   
		 $data = $this->getBodyParams();
		 $response = ['success' => false];
		 if(!empty($data)){
			 
			 $returnArray = $this->helper->requiredFields($data , true , 'register');
			 
			 if($returnArray['status'] != "error"){
				 $flag = "";
				    try {
						if (!empty($returnArray)) {

							$user_data = $this->registrationData->create();
							$user_data = $user_data->getData();
							
							if(empty($user_data)){
							   $flag = true;
							}
							 foreach($user_data as $key=>$value){
								$flag = !(in_array($returnArray['email'], $value));
							}
							//echo json_encode(array('response' => $flag));exit;
							 
						  
							if($flag){
								$model = $this->PostFactory->create();
								$model->setData($returnArray)->save();
								$id =  $model->getRegId();
							    $this->helper->createToken($id);
 								$response = ['success' => true, 'message' => "Registred Successfully"];
								echo json_encode(array('response' => $response));
							}else{
								$response = ['success' => false, 'message' => "User Already Registered"];
								echo json_encode(array('response' => $response));
							}
						}
					} catch (\Exception $e) {
						$response = ['success' => false, 'message' => $returnArray];
						echo json_encode(array('response' => $response));
					}
				
			 }else{
				$response = ['success' => false, 'message' => $returnArray];
				echo json_encode(array('response' => $response));
			 }
		 }else{
			 echo json_encode(array('response' => $response));
		 }
	}
	
	
}
