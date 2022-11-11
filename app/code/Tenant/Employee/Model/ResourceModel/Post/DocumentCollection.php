<?php
namespace Tenant\Employee\Model\ResourceModel\Post;

class DocumentCollection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
	protected $_idFieldName = 'emp_no';
	protected $_eventPrefix = 'Document_Document_Documentcollection';
	protected $_eventObject = 'Document_collection';

	/**
	 * Define resource model
	 *
	 * @return void
	 */
	protected function _construct()
	{
		$this->_init('Tenant\Employee\Model\Document', 'Tenant\Employee\Model\ResourceModel\Document');
	}
}