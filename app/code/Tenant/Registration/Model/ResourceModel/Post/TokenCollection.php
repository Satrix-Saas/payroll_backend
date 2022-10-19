<?php
namespace Tenant\Registration\Model\ResourceModel\Post;

class ToeknCollection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
	protected $_idFieldName = 'id';
	protected $_eventPrefix = 'token_post_collection';
	protected $_eventObject = 'token_collection';

	/**
	 * Define resource model
	 *
	 * @return void
	 */
	protected function _construct()
	{
		$this->_init('Tenant\Registration\Model\Token', 'Tenant\Registration\Model\ResourceModel\Token');
	}

}