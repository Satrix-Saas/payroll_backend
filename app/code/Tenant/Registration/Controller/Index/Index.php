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
	  $user_array = $this->getResponseArray();
		// echo"<pre>";print_r($user_array);exit;
		 $data = $this->getBodyParams();
		 $response = ['ResponseCode' => $user_array['ResponseCode']['false']];
		 if(!empty($data)){
			 $returnArray = $this->helper->requiredFields($data , 1 , 'register');
			 
			 if($returnArray['status'] != "error"){
				 $flag = "";
				    try {
						if (!empty($returnArray)) {

							$user_data = $this->registrationData->create();
							$user_data = $user_data->getData();
							
							if(empty($user_data)){
							   $flag = 1;
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
 								$response = ['ResponseCode' => $user_array['ResponseCode']['true'], 'ResponseMessage' => $user_array['register']['true']];
								echo json_encode(array('response' => $response));
							}else{
								$response = ['ResponseCode' => $user_array['ResponseCode']['false'], 'ResponseMessage' => $user_array['register']['false']];
								echo json_encode(array('response' => $response));
							}
						}
					} catch (\Exception $e) {
						$response = ['ResponseCode' => $user_array['ResponseCode']['false'], 'ResponseMessage' => $user_array['dbexception']];
						echo json_encode(array('response' => $response));
					}
				
			 }else{
				$response = ['ResponseCode' => $user_array['ResponseCode']['false'], 'ResponseMessage' => $returnArray];
				echo json_encode(array('response' => $response));
			 }
		 }else{
			 echo json_encode(array('response' => $response));
		 }
	}
	
	
}
