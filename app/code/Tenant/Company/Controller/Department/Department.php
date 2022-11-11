<?php
namespace Tenant\Company\Controller\Department;

use Tenant\Company\Model\DepartmentFactory;
use Tenant\Company\Model\ResourceModel\Post\DepartmentCollectionFactory;
use Magento\Framework\Controller\ResultFactory;
use Tenant\Satrix\Helper\Data;

class Department extends \Tenant\Satrix\Controller\Api\BaseApi
{
    protected $_pageFactory;
    protected $resultPageFactory;
    protected $_request;

    public function __construct(
        \Magento\Framework\App\Action\Context $context,
        \Magento\Framework\App\Request\Http $request,
        DepartmentCollectionFactory $Departmentdata,
        Data $helper,
        DepartmentFactory $DepartmentFactory
    ) {
        $this->_request = $request;
        $this->helper = $helper;
        $this->DepartmentFactory = $DepartmentFactory;
        $this->Departmentdata = $Departmentdata;
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
                "department"
            );

            if ($returnArray["status"] != "error") {
                try {
                    if (!empty($returnArray)) {
                        $Department_data = $this->Departmentdata->create();
                        $Department_data = $Department_data->getData();
					
                            $model = $this->DepartmentFactory->create();
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

