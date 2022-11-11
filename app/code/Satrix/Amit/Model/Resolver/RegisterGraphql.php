<?php

namespace Satrix\Amit\Model\Resolver;

use Magento\Framework\GraphQl\Config\Element\Field;
use Magento\Framework\GraphQl\Exception\GraphQlInputException;
use Magento\Framework\GraphQl\Query\ResolverInterface;
use Magento\Framework\GraphQl\Schema\Type\ResolveInfo;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\GraphQl\Exception\GraphQlNoSuchEntityException;

class RegisterGraphql implements ResolverInterface
{
    private $customDataProvider;

    public function __construct(
        \Satrix\Amit\Model\PostFactory $PostFactory
    ) {
		$this->PostFactory = $PostFactory;
    }

    public function resolve(
        Field $field,
        $context,
        ResolveInfo $info,
        array $value = null,
        array $args = null
    ) {
		$output = [];
        // $user_data = $this->registrationData->create();
		$data = $this->PostFactory->create()->load($args['email'],'email');
		$output['output'] = json_encode($data->getData());	
				

		return $output;
    }
}

?>