<?php
namespace Tenant\Company\Model\ResourceModel\Post;

class DepartmentCollection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
	protected $_idFieldName = 'dept_id';
	protected $_eventPrefix = 'department_department_departmentcollection';
	protected $_eventObject = 'department_collection';

	/**
	 * Define resource model
	 *
	 * @return void
	 */
	protected function _construct()
	{
		$this->_init('Tenant\Company\Model\Department', 'Tenant\Company\Model\ResourceModel\Department');
	}
}