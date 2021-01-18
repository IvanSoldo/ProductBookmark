<?php


namespace Inchoo\ProductBookmark\Model;


use Inchoo\ProductBookmark\Api\Data\BookmarkInterface;
use Magento\Framework\Model\AbstractModel;

class Bookmark extends AbstractModel implements BookmarkInterface
{

    protected function _construct()
    {
        $this->_init(ResourceModel\Bookmark::class);
    }

    public function getId()
    {
        return $this->getData(self::BOOKMARK_ID);
    }

    public function getBookmarkListId()
    {
        return $this->getData(self::BOOKMARK_LIST_ID);
    }

    public function getProductId()
    {
        return $this->getData(self::PRODUCT_ID);
    }

    public function setId($id)
    {
        return $this->setData(self::BOOKMARK_ID, $id);
    }

    public function setBookmarkListId($bookmarkListId)
    {
        return $this->setData(self::BOOKMARK_LIST_ID, $bookmarkListId);
    }

    public function setProductId($productId)
    {
        return $this->setData(self::PRODUCT_ID, $productId);
    }
}
