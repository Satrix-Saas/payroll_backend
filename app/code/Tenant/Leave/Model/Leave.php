<?php
namespace Tenant\Leave\Model;
class Leave extends \Magento\Framework\Model\AbstractModel implements \Magento\Framework\DataObject\IdentityInterface
{
	const CACHE_TAG = 'formdata';

	protected $_cacheTag = 'formdata';

	protected $_eventPrefix = 'formdata';

	protected function _construct()
	{
		$this->_init('Tenant\Leave\Model\ResourceModel\Leave');
	}

	public function getIdentities()
	{
		return [self::CACHE_TAG . '_' . $this->getId()];
	}

	public function getDefaultValues()
	{
		$values = [];

		return $values;
	}
}