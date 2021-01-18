<?php


namespace Inchoo\ProductBookmark\Model\ResourceModel\Bookmark;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{

    protected function _construct()
    {
        $this->_init(\Inchoo\ProductBookmark\Model\Bookmark::class,
            \Inchoo\ProductBookmark\Model\ResourceModel\Bookmark::class);
    }

}
