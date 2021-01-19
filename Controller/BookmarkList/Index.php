<?php


namespace Inchoo\ProductBookmark\Controller\BookmarkList;

use Inchoo\ProductBookmark\Controller\Bookmark;
use Magento\Framework\Controller\ResultFactory;

class Index extends Bookmark
{
    private $resultPageFactory;

    public function execute()
    {
        return $this->resultFactory->create(ResultFactory::TYPE_PAGE);
    }
}
