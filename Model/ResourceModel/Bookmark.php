<?php


namespace Inchoo\ProductBookmark\Model\ResourceModel;


use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class Bookmark extends AbstractDb
{

    protected function _construct()
    {
        $this->_init('inchoo_bookmark', 'bookmark_id');
    }
}
