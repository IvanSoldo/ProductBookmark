<?php


namespace Inchoo\ProductBookmark\Controller\Block;


use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\View\Result\LayoutFactory as LayoutResultFactory;

class Index extends Action
{

    private $layoutResultFactory;

    public function __construct(Context $context, LayoutResultFactory $layoutResultFactory)
    {
        parent::__construct($context);
        $this->layoutResultFactory = $layoutResultFactory;
    }

    public function execute()
    {
        $result = $this->layoutResultFactory->create();
        $result->addHandle('inchoo_ajax_bookmark');
        return $result;
    }
}
