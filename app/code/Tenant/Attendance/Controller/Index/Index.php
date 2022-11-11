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
                false,
                "attendance"
            );
            if ($returnArray["status"] != "error") {
                try {
                    if (!empty($returnArray)) {
                        //  echo"<pre>";print_r($returnArray);
                        $Attendance_data = $this->Attendancedata->create();
                        $Attendance_data = $Attendance_data->getData();
                        if(empty($Attendance_data)){
                                $model = $this->AttendanceFactory->create();
                                $model->setData($returnArray)->save();
                                $response = [
                                "ResponseCode" => 1,
                                "ResponseMessage" => "Data inserted Successfully",
                            ];
                            echo json_encode(["response" => $response]);
                            }
             // -------------------------------------------------------------------------------------------------
                            foreach($Attendance_data as $key=>$value){
                              
                                if(in_array($returnArray['punch_date'], $value)){
                                    
                                    if($returnArray['punch_date'] != $value['punch_date'] && $returnArray['emp_id'] != $value['emp_id'] ){	
                                        $model = $this->AttendanceFactory->create();
                                        $model->setData($returnArray)->save();
                                        $response = [
                                        "ResponseCode" => 1,
                                        "ResponseMessage" => "Data inserted Successfully",
                                    ];
                                    echo json_encode(["response" => $response]);
                                }
                                  else{
                                        if($returnArray['punch_date'] === $value['punch_date']){	
                                        $model =  $this->AttendanceFactory->create()->load($value['punch_date'],'punch_date');
                                        $model->setPunchOut($returnArray['punch_out']);
                                        $model->save();
                                        $response = ['ResponseCode' => 1, 'ResponseMessage' => "punchout update"];
                                        echo json_encode(array('response' => $response));								
                                    }else{
                                        $response = ['ResponseCode' => 0, 'ResponseMessage' => "Aleady punchout"];
                                        echo json_encode(array('response' => $response));
                                    }
                                }
                            }
                            }
                        }else{
                            $response = ['ResponseCode' => 0, 'ResponseMessage' => "Aleady punchout"];
                            echo json_encode(array('response' => $response));
                    }      
                    }catch (\Exception $e) {
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