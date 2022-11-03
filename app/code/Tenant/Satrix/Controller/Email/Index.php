<?php

namespace Tenant\Satrix\Controller\Email;


class Index extends \Magento\Framework\App\Action\Action
{
	/**
     * @var \Magento\Framework\Mail\Template\TransportBuilder
     */
    protected $_transportBuilder;

    /**
     * @var \Magento\Store\Model\StoreManagerInterface
    */
    protected $_storeManager;


    public function __construct(
		\Magento\Framework\App\Action\Context $context,
        \Magento\Framework\Mail\Template\TransportBuilder $transportBuilder,
        \Magento\Store\Model\StoreManagerInterface $storeManager

    )
    {
        $this->_transportBuilder = $transportBuilder;
        $this->_storeManager     = $storeManager;
		 parent::__construct($context);
    }

    public function execute(){
		$email = "satrixsaas@gmail.com";
		$name = "Satrix";
        $store = $this->_storeManager->getStore()->getId();
        $template   = "customemail_email_template";

        /* Receiver Detail  */
        $receiverInfo = [
        'name' => $name,
        'email' => $email,
        ];


        /* Sender Detail  */
        $senderInfo = [
            'name' => 'Satrix_saas',
            'email' => 'satrixsaas@gmail.com',
        ];

        $this->_transportBuilder->setTemplateIdentifier($template);
        $transport = [
            'name'           => $name,
            'email'           => $email,
        ];
        $this->_transportBuilder->setFrom($senderInfo);
        $this->_transportBuilder->addTo($receiverInfo['email'],$receiverInfo['name']);
        $this->_transportBuilder->setTemplateVars($transport);
        $this->_transportBuilder->setTemplateOptions(['area' => \Magento\Framework\App\Area::AREA_FRONTEND, 'store' => $store]);
        $transport = $this->_transportBuilder->getTransport();
        $transport->sendMessage();

     }
}