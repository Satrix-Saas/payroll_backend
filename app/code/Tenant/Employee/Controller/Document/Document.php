<?php
namespace Tenant\Employee\Controller\Document;

use Tenant\Employee\Model\DocumentFactory;
use Tenant\Employee\Model\ResourceModel\Post\DocumentCollectionFactory;
use Magento\Framework\Controller\ResultFactory;
use Tenant\Satrix\Helper\Data;

class Document extends \Tenant\Satrix\Controller\Api\BaseApi
{
    protected $_pageFactory;
    protected $resultPageFactory;
    protected $_request;

    public function __construct(
        \Magento\Framework\App\Action\Context $context,
        \Magento\Framework\App\Request\Http $request,
        DocumentCollectionFactory $documentdata,
        Data $helper,
        DocumentFactory $documentFactory
    ) {
        $this->_request = $request;
        $this->helper = $helper;
        $this->DocumentFactory = $documentFactory;
        $this->documentdata = $documentdata;
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
                "document"
            );

            if ($returnArray["status"] != "error") {
                try {
                    if (!empty($returnArray)) {
                        // echo json_encode(["response" => $returnArray]);
                        // exit;

                        $document_data = $this->documentdata->create();
                        $document_data = $document_data->getData();
                        // echo json_encode(["response" => $document_data]);
                        // exit;

                            $model = $this->DocumentFactory->create();
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