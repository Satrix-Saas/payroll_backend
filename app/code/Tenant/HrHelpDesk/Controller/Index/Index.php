<?php
namespace Tenant\HrHelpDesk\Controller\Index;


use Magento\Framework\Controller\ResultFactory;


class Index extends \Tenant\Satrix\Controller\Api\BaseApi
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
		$helpdesk = array();
		$helpdesk['data'] = "abc";
		$resultJson->setData($helpdesk);
		$resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
        $resultRedirect->setUrl($this->_redirect->getRefererUrl());
		$message = __('Hr HelpDesk Data Save Successful'); 
		$this->messageManager->addSuccessMessage($message);
        return $resultRedirect;
	}
}
