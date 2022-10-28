<?php
namespace Tenant\Employee\Model\ResourceModel\Post;

class EmployeeCollection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
	protected $_idFieldName = 'emp_id';
	protected $_eventPrefix = 'Employee_Employee_Employeecollection';
	protected $_eventObject = 'Employee_collection';

	/**
	 * Define resource model
	 *
	 * @return void
	 */
	protected function _construct()
	{
		$this->_init('Tenant\Employee\Model\Employee', 'Tenant\Employee\Model\ResourceModel\Employee');
	}
}