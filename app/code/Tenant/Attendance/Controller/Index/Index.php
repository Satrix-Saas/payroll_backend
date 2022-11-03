<?php
namespace Tenant\Attendance\Controller\Index;

use Tenant\Attendance\Model\AttendanceFactory;
use Tenant\Attendance\Model\ResourceModel\Post\AttendanceCollectionFactory;
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
        AttendanceCollectionFactory $Attendancedata,
        Data $helper,
        AttendanceFactory $AttendanceFactory
    ) {
        $this->_request = $request;
        $this->helper = $helper;
        $this->AttendanceFactory = $AttendanceFactory;
        $this->Attendancedata = $Attendancedata;
        return parent::__construct($context);
    }

    public function execute()
    {
        $data = $this->getBodyParams();
        // echo"<pre>";print_r($data);
        // exit;
        $response = ["success" => false];
        if (!empty($data)) {
            $returnArray = $this->helper->requiredFields(
                $data,
                true,
                "attendance"
            );

            if ($returnArray["status"] != "error") {
                try {
                    if (!empty($returnArray)) {
						echo json_encode(["response" => $returnArray]);
                        $Attendance_data = $this->Attendancedata->create();
                        $Attendance_data = $Attendance_data->getData();
						echo json_encode(["response" => $Attendance_data]);
					
                            $model = $this->AttendanceFactory->create();
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