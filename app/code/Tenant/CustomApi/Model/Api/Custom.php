<?php
namespace Tenant\CustomApi\Model\Api;

use Tenant\CustomApi\Api\CustomInterface;
use Psr\Log\LoggerInterface;
class Custom implements CustomInterface
{
    protected $logger;
    public function __construct(
        LoggerInterface $logger
    )
    {
        $this->logger = $logger;
    }
    /* @param string  $value

    * @return \Tenant\CustomApi\Api\CustomInterface

    * @throws \Magento\Framework\Exception\NoSuchEntityException

    */
		public function getAuthToken(){

		$token = false;

		$headers = []; 
		foreach ($_SERVER as $name => $value) 
		{ 
			if (substr($name, 0, 5) == 'HTTP_') 
			{ 
				$headers[str_replace(' ', '-', ucwords(strtolower(str_replace('_', ' ', substr($name, 5)))))] = $value; 
			} 
		}
		$authorizationBearer = '';
        echo ($headers['Authorization']);exit;
		if(isset($headers['Authorization'])) {
			$authorizationBearer = $headers['Authorization'];
		} else if(isset($headers['authorization'])) {
			$authorizationBearer = $headers['authorization'];
		} else {
			$authorizationBearer = "";
		}

		$authorizationBearerArr = explode(' ', $authorizationBearer);
		if(
			isset($authorizationBearerArr[0]) && 
			trim($authorizationBearerArr[0]) == 'Bearer' && 
			isset($authorizationBearerArr[1])
		){
			$token = $authorizationBearerArr[1];
		}

		return $token;
	}
	
    public function getPost($value)
    {
        $response = ['success' => false];
        try {
            // Your Code here
            $response = ['success' => true, 'message' => $value];
        } catch (\Exception $e) {
            $response = ['success' => false, 'message' => $e->getMessage()];
            $this->logger->info($e->getMessage());
        }
        $returnArray = json_encode($response);
        return $returnArray; 
   }
   
   public function getUserData($id)
    {
        return $id; 
   }
}