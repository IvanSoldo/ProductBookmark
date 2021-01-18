<?php

namespace Inchoo\ProductBookmark\Api;

use Inchoo\ProductBookmark\Api\Data\BookmarkListInterface;
use Magento\Framework\Api\SearchCriteriaInterface;

interface BookmarkListRepositoryInterface
{

    /**
     * @param $bookmarkListId
     * @return mixed
     */
    public function getById($bookmarkListId);

    /**
     * @param BookmarkListInterface $bookmarkList
     * @return mixed
     */
    public function save(BookmarkListInterface $bookmarkList);

    /**
     * @param BookmarkListInterface $bookmarkList
     * @return mixed
     */
    public function delete(BookmarkListInterface $bookmarkList);

    /**
     * @param SearchCriteriaInterface $searchCriteria
     * @return mixed
     */
    public function getList(SearchCriteriaInterface $searchCriteria);
}
