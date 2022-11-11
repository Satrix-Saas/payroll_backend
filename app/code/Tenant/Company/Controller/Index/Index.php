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
                        $Company_data = $this->Companydata->create();
                        $Company_data = $Company_data->getData();
					
                            $model = $this->CompanyFactory->create();
                            $model->setData($returnArray)->save();
                            $response = [
                                "ResponseCode" => 1,
                                "ResponseMessage" => "Data inserted Successfully",
                            ];
                            echo json_encode(["response" => $response]);
                        }
					  else {
                            $response = [
                                "ResponseCode" => 0,
                                "ResponseMessage" => "Error",
                            ];
                            echo json_encode(["response" => $response]);
                        }
					}
						
                 catch (\Exception $e) {
                    $response = [
                        "ResponseCode" => 0,
                        "ResponseMessage" => "db_exception",
                    ];
                    echo json_encode(["ResponseMessage" => $response]);
                }
            } else {
                $response = ["ResponseCode" => 0, "ResponseMessage" => $returnArray];
                echo json_encode(["ResponseMessage" => $response]);
            }
        } else {
            echo json_encode(["ResponseMessage" => $response]);
        }
    }
}

