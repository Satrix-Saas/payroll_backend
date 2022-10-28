<?php
namespace Tenant\Company\Controller\Leave;

use Tenant\Company\Model\LeaveFactory;
use Tenant\Company\Model\ResourceModel\Post\LeaveCollectionFactory;
use Magento\Framework\Controller\ResultFactory;
use Tenant\Satrix\Helper\Data;

class Leave extends \Tenant\Satrix\Controller\Api\BaseApi
{
    protected $_pageFactory;
    protected $resultPageFactory;
    protected $_request;

    public function __construct(
        \Magento\Framework\App\Action\Context $context,
        \Magento\Framework\App\Request\Http $request,
        LeaveCollectionFactory $Leavedata,
        Data $helper,
        LeaveFactory $LeaveFactory
    ) {
        $this->_request = $request;
        $this->helper = $helper;
        $this->LeaveFactory = $LeaveFactory;
        $this->Leavedata = $Leavedata;
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
                "leave"
            );

            if ($returnArray["status"] != "error") {
                try {
                    if (!empty($returnArray)) {
						// echo json_encode(["response" => $returnArray]);
                        // $leave_data = $this->Leavedata->create();
                        // $leave_data = $leave_data->getData();
						// echo json_encode(["response" => $leave_data]);
					
                            $model = $this->LeaveFactory->create();
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