<?php
namespace Tenant\Leave\Controller\Index;

use Tenant\Leave\Model\LeaveFactory;
use Tenant\Leave\Model\ResourceModel\Post\LeaveCollectionFactory;
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
        $response = ["ResponseCode" => false];
        if (!empty($data)) {
            $returnArray = $this->helper->requiredFields(
                $data,
                true,
                "leave"
            );

            if ($returnArray["status"] != "error") {
                try {
                    if (!empty($returnArray)) {
                            $model = $this->LeaveFactory->create();
                            $model->setData($returnArray)->save();

                            $response = [
                                "ResponseCode" => 1,
                                "ResponseMessage" => "Data inserted ",
                            ];
                            echo json_encode(["response" => $response]);
                        }
                        else{
                            $response = ['ResponseCode' => 0, 'ResponseMessage' => "not inserted"];
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