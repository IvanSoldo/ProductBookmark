<?php

namespace Inchoo\ProductBookmark\Model;

use Inchoo\ProductBookmark\Api\Data\BookmarkListInterface;
use Magento\Framework\Model\AbstractModel;

class BookmarkList extends AbstractModel implements BookmarkListInterface
{

    protected function _construct()
    {
        $this->_init(ResourceModel\BookmarkList::class);
    }

    public function getId()
    {
        return $this->getData(self::BOOKMARK_LIST_ID);
    }

    public function getBookmarkListTitle()
    {
        return $this->getData(self::BOOKMARK_LIST_TITLE);
    }

    public function getCustomerId()
    {
        return $this->getData(self::CUSTOMER_ID);
    }

    public function setId($id)
    {
        return $this->setData(self::BOOKMARK_LIST_ID, $id);
    }

    public function setBookmarkListTitle($title)
    {
        return $this->setData(self::BOOKMARK_LIST_TITLE, $title);
    }

    public function setCustomerId($customerId)
    {
        return $this->setData(self::CUSTOMER_ID, $customerId);
    }
}
