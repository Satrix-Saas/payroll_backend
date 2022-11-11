<?php
namespace Tenant\Employee\Controller\Holiday;

use Tenant\Employee\Model\HolidayFactory;
use Tenant\Employee\Model\ResourceModel\Post\HolidayCollectionFactory;
use Magento\Framework\Controller\ResultFactory;
use Tenant\Satrix\Helper\Data;

class Holiday extends \Tenant\Satrix\Controller\Api\BaseApi
{
    protected $_pageFactory;
    protected $resultPageFactory;
    protected $_request;

    public function __construct(
        \Magento\Framework\App\Action\Context $context,
        \Magento\Framework\App\Request\Http $request,
        HolidayCollectionFactory $Holidaydata,
        Data $helper,
        HolidayFactory $HolidayFactory
    ) {
        $this->_request = $request;
        $this->helper = $helper;
        $this->HolidayFactory = $HolidayFactory;
        $this->Holidaydata = $Holidaydata;
        return parent::__construct($context);
    }

    public function execute()
    {
        $data = $this->getBodyParams();
        $response = ["ResponseCode" => 0];
        if (!empty($data)) {
            $returnArray = $this->helper->requiredFields(
                $data,
                true,
                "holiday"
            );

            if ($returnArray["status"] != "error") {
                try {
                    if (!empty($returnArray)) {
                        $Holiday_data = $this->Holidaydata->create();
                        $Holiday_data = $Holiday_data->getData();
					
                            $model = $this->HolidayFactory->create();
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