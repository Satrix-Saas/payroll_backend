<?php
namespace Tenant\Satrix\Controller\Index;

use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Framework\App\Helper\Context;
use Magento\Framework\Translate\Inline\StateInterface;
use Magento\Framework\Escaper;
use Magento\Framework\Mail\Template\TransportBuilder;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Store\Model\StoreManagerInterface;


class Index extends AbstractHelper
{
	protected $inlineTranslation;
    protected $escaper;
    protected $transportBuilder;
    protected $logger;
    protected $scopeConfig;
    protected $storeManager;

	public function __construct(
        Context $context,
        StateInterface $inlineTranslation,
        Escaper $escaper,
        TransportBuilder $transportBuilder,
        StoreManagerInterface $storeManager,
        ScopeConfigInterface $scopeConfig
    ) {
        parent::__construct($context);
        $this->inlineTranslation = $inlineTranslation;
        $this->escaper = $escaper;
        $this->transportBuilder = $transportBuilder;
        $this->logger = $context->getLogger();
        $this->scopeConfig = $scopeConfig; 
        $this->storeManager = $storeManager;

    }

   	
	public function execute()
    { 
	   $orderId = '12';
        $shipping_label_path = '12';
        $pdf_name = 'abcd' ;
        $customer_name = 'dcba';
         $customerEmail = 'satrixsaas@gamil.com';
        try {
            $this->inlineTranslation->suspend();
            $sender_name = $this->scopeConfig->getValue('general/store_information/name',\Magento\Store\Model\ScopeInterface::SCOPE_STORE);
            $sender_email = $this->scopeConfig->getValue('trans_email/ident_general/email',\Magento\Store\Model\ScopeInterface::SCOPE_STORE);
            $sender = [
                'name' => $this->escaper->escapeHtml($sender_name),
                'email' => $this->escaper->escapeHtml($sender_email),
            ];
            $transport = $this->transportBuilder
                ->setTemplateIdentifier('ayakil_email_label_template')
                ->setTemplateOptions(
                    [
                        'area' => \Magento\Framework\App\Area::AREA_FRONTEND,
                        'store' => $this->storeManager->getStore()->getId(),
                    ]
                )
                ->setTemplateVars([
                    'customer_name'  => $customer_name,
                    'shipping_label'  => $shipping_label_path,
                    'order_id' => $orderId,
                ])
                ->setFrom($sender)
                ->addTo($customerEmail)
                ->getTransport();
            $transport->sendMessage();
            $this->inlineTranslation->resume();
        } catch (\Exception $e) {
            $this->logger->debug($e->getMessage());
        }
    }
	
	
}
