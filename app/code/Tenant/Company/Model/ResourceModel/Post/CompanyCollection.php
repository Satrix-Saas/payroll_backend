<?php
namespace Tenant\Company\Model\ResourceModel\Post;

class CompanyCollection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
	protected $_idFieldName = 'cmp_id';
	protected $_eventPrefix = 'company_company_companycollection';
	protected $_eventObject = 'company_collection';

	/**
	 * Define resource model
	 *
	 * @return void
	 */
	protected function _construct()
	{
		$this->_init('Tenant\Company\Model\Company', 'Tenant\Company\Model\ResourceModel\Company');
	}
}