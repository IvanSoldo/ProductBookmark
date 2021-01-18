<?php


namespace Inchoo\ProductBookmark\Api\Data;


interface BookmarkListInterface
{
    const BOOKMARK_LIST_ID = 'bookmark_list_id';
    const BOOKMARK_LIST_TITLE = 'bookmark_list_title';
    const CUSTOMER_ID = 'customer_id';

    /**
     * @return mixed
     */
    public function getId();

    /**
     * @return mixed
     */
    public function getBookmarkListTitle();

    /**
     * @return mixed
     */
    public function getCustomerId();

    /**
     * @param $id
     * @return mixed
     */
    public function setId($id);

    /**
     * @param $title
     * @return mixed
     */
    public function setBookmarkListTitle($title);

    /**
     * @param $customerId
     * @return mixed
     */
    public function setCustomerId($customerId);
}
