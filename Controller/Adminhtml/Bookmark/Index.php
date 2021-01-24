<?php

namespace Inchoo\ProductBookmark\Controller\Adminhtml\Bookmark;

use Magento\Backend\App\Action;
use Magento\Framework\Controller\ResultFactory;

class Index extends Action
{

    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('Inchoo_ProductBookmark::productbookmark');
    }

    public function execute()
    {

        $resultPage = $this->resultFactory->create(ResultFactory::TYPE_PAGE);

        $resultPage->setActiveMenu('Inchoo_ProductBookmark::productbookmark');
        $resultPage->getConfig()->getTitle()->prepend(__('Bookmarks'));

        return $resultPage;
    }
}
