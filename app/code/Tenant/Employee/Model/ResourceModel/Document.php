<?php
namespace Tenant\Employee\Model\ResourceModel;


class Document extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{
	
	public function __construct(
		\Magento\Framework\Model\ResourceModel\Db\Context $context
	)
	{
		parent::__construct($context);
	}
	protected function _construct()
	{
		$this->_init('document', 'emp_no');
	}
}