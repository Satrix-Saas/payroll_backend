<?php
namespace Tenant\Company\Model\ResourceModel\Post;

class LeaveCollection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
	protected $_idFieldName = 'emp_id';
	protected $_eventPrefix = 'Leave_Leave_Leavecollection';
	protected $_eventObject = 'Leave_collection';

	/**
	 * Define resource model
	 *
	 * @return void
	 */
	protected function _construct()
	{
		$this->_init('Tenant\Company\Model\Leave', 'Tenant\Company\Model\ResourceModel\Leave');
	}
}