<?php
namespace Tenant\Company\Controller\Index;

use Tenant\Company\Model\CompanyFactory;
use Tenant\Company\Model\ResourceModel\Post\CompanyCollectionFactory;
use Magento\Framework\Controller\ResultFactory;
use Tenant\Satrix\Helper\Data;

class Index extends \Tenant\Satrix\Controller\Api\BaseApi
{
    protected $_pageFactory;
    protected $resultPageFactory;
    protected $_request;

    public function __construct(
        \Magento\Framework\App\Action\Context $context,
        \Magento\Framework\App\Request\Http $request,
        CompanyCollectionFactory $Companydata,
        Data $helper,
        CompanyFactory $CompanyFactory
    ) {
        $this->_request = $request;
        $this->helper = $helper;
        $this->CompanyFactory = $CompanyFactory;
        $this->Companydata = $Companydata;
        return parent::__construct($context);
    }

    public function execute()
    {
        $data = $this->getBodyParams();
        $response = ["success" => false];
        if (!empty($data)) {
            $returnArray = $this->helper->requiredFields(
                $data,
                true,
                "company"
            );

            if ($returnArray["status"] != "error") {
                try {
                    if (!empty($returnArray)) {
						// echo json_encode(["response" => $returnArray]);
                        $Company_data = $this->Companydata->create();
                        $Company_data = $Company_data->getData();
						echo json_encode(["response" => $Company_data]);
					
                            $model = $this->CompanyFactory->create();
                            $model->setData($returnArray)->save();
                            $response = [
                                "success" => true,
                                "message" => "Data inserted Successfully",
                            ];
                            echo json_encode(["response" => $response]);
                        }
					  else {
                            $response = [
                                "success" => false,
                                "message" => "Error",
                            ];
                            echo json_encode(["response" => $response]);
                        }
					}
						
                 catch (\Exception $e) {
                    $response = [
                        "success" => false,
                        "message" => "db_exception",
                    ];
                    echo json_encode(["response" => $response]);
                }
            } else {
                $response = ["success" => false, "message" => $returnArray];
                echo json_encode(["response" => $response]);
            }
        } else {
            echo json_encode(["response" => $response]);
        }
    }
}

// echo '<pre>';print_r($data);exit;
// $resultJson = $this->resultFactory->create(ResultFactory::TYPE_JSON);
// $company = array();
// $company['email'] = "abc";
// $company['brandname'] = "abc";
// $company['address'] = "abc";
// $company['state'] = "abc";
// $company['pin'] = "abc";
// $resultJson->setData($company);
// return $resultJson;
