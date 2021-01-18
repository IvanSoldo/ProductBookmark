<?php


namespace Inchoo\ProductBookmark\Api\Data;


interface BookmarkInterface
{
    const BOOKMARK_ID = 'bookmark_id';
    const BOOKMARK_LIST_ID = 'bookmark_list_id';
    const PRODUCT_ID = 'product_id';

    /**
     * @return mixed
     */
    public function getId();

    /**
     * @return mixed
     */
    public function getBookmarkListId();

    /**
     * @return mixed
     */
    public function getProductId();

    /**
     * @param $id
     * @return mixed
     */
    public function setId($id);

    /**
     * @param $bookmarkListId
     * @return mixed
     */
    public function setBookmarkListId($bookmarkListId);

    /**
     * @param $productId
     * @return mixed
     */
    public function setProductId($productId);

}