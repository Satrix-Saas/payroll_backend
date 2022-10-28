<?php
namespace Tenant\Employee\Model\ResourceModel\Post;

class HolidayCollection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
	protected $_idFieldName = 'sr_no';
	protected $_eventPrefix = 'Holiday_Holiday_HolidayCollection';
	protected $_eventObject = 'Holiday_collection';

	/**
	 * Define resource model
	 *
	 * @return void
	 */
	protected function _construct()
	{
		$this->_init('Tenant\Employee\Model\Holiday', 'Tenant\Employee\Model\ResourceModel\Holiday');
	}
}