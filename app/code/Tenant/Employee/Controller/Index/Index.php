<?php
namespace Tenant\Employee\Controller\Index;

use Tenant\Employee\Model\EmployeeFactory;
use Tenant\Employee\Model\ResourceModel\Post\EmployeeCollectionFactory;
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
        EmployeeCollectionFactory $Employeedata,
        Data $helper,
        EmployeeFactory $EmployeeFactory
    ) {
        $this->_request = $request;
        $this->helper = $helper;
        $this->EmployeeFactory = $EmployeeFactory;
        $this->Employeedata = $Employeedata;
        return parent::__construct($context);
    }

    public function execute()
    {
        $data = $this->getBodyParams();
        $response = ["ResponseCode" => 0];
        if (!empty($data)) {
            $returnArray = $this->helper->requiredFields(
                $data,
                1,
                "employee"
            );

            if ($returnArray["status"] != "error") {
                try {
                    if (!empty($returnArray)) {
                        $Employee_data = $this->Employeedata->create();
                        $Employee_data = $Employee_data->getData();
					
                            $model = $this->EmployeeFactory->create();
                            $model->setData($returnArray)->save();

                            $response = [
                                "ResponseCode" => 1,
                                "ResponseMessage" => "Employee registered Successfully",
                            ];
                            echo json_encode(["response" => $response]);
                        }
                        else{
                            $response = ['ResponseCode' => 0, 'ResponseMessage' => "User Already Registered"];
                            echo json_encode(array('response' => $response));
                        }
					}
						
                 catch (\Exception $e) {
                    $response = [
                        "ResponseCode" => 0,
                        "ResponseMessage" => "db_exception",
                    ];
                    echo json_encode(["response" => $response]);
                }
            } else {
                $response = ["ResponseCode" => 0, "ResponseMessage" => $returnArray];
                echo json_encode(["response" => $response]);
            }
        } else {
            echo json_encode(["response" => $response]);
        }
    }
}