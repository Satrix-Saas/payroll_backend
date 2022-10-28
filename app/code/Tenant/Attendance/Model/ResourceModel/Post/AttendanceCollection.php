<?php
namespace Tenant\Attendance\Model\ResourceModel\Post;

class AttendanceCollection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
	protected $_idFieldName = 'sr_no';
	protected $_eventPrefix = 'attendance_attendance_attendancecollection';
	protected $_eventObject = 'attendance_collection';

	/**
	 * Define resource model
	 *
	 * @return void
	 */
	protected function _construct()
	{
		$this->_init('Tenant\Attendance\Model\Attendance', 'Tenant\Attendance\Model\ResourceModel\Attendance');
	}
}