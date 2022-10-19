<?php
namespace Tenant\Company\Controller\Index;


use Magento\Framework\Controller\ResultFactory;


class Index extends \Magento\Framework\App\Action\Action
{
	protected $_pageFactory;
    protected $resultPageFactory;

	public function __construct(
		\Magento\Framework\App\Action\Context $context,
		\Magento\Framework\View\Result\PageFactory $pageFactory,
		\Magento\Framework\Message\ManagerInterface $messageManager
         )
	{
		$this->messageManager = $messageManager;
       	return parent::__construct($context);
	}

    public function execute()
    { 
		$resultJson = $this->resultFactory->create(ResultFactory::TYPE_JSON);
		$company = array();
		$company['email'] = "abc";
		$company['brandname'] = "abc";
		$company['address'] = "abc";
		$company['state'] = "abc";	
		$company['pin'] = "abc";
		$resultJson->setData($company);
        return $resultJson;
	}
}
