<?php

namespace Inchoo\ProductBookmark\Model;

use Inchoo\ProductBookmark\Api\BookmarkListRepositoryInterface;
use Inchoo\ProductBookmark\Api\Data\BookmarkListInterface;
use Inchoo\ProductBookmark\Api\Data\BookmarkListSearchResultsInterface;
use Inchoo\ProductBookmark\Model\ResourceModel\BookmarkList\CollectionFactory;
use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;

class BookmarkListRepository implements BookmarkListRepositoryInterface
{

    /**
     * @var \Inchoo\ProductBookmark\Api\Data\BookmarkListInterfaceFactory
     */
    protected $bookmarkListModelFactory;

    /**
     * @var \Inchoo\ProductBookmark\Model\ResourceModel\BookmarkList
     */
    protected $bookmarkListResource;

    /**
     * @var CollectionFactory
     */
    protected $bookmarkListCollectionFactory;

    /**
     * @var \Inchoo\ProductBookmark\Api\Data\BookmarkListSearchResultsInterfaceFactory
     */
    protected $searchResultFactory;

    /**
     * @var CollectionProcessorInterface
     */
    private $collectionProcessor;

    public function __construct(
        \Inchoo\ProductBookmark\Api\Data\BookmarkListInterfaceFactory $bookmarkListModelFactory,
        \Inchoo\ProductBookmark\Model\ResourceModel\BookmarkList $bookmarkListResource,
        CollectionFactory $bookmarkListCollectionFactory,
        \Inchoo\ProductBookmark\Api\Data\BookmarkSearchResultsInterfaceFactory $searchResultFactory,
        CollectionProcessorInterface $collectionProcessor
    )
    {
        $this->bookmarkListModelFactory = $bookmarkListModelFactory;
        $this->bookmarkListResource = $bookmarkListResource;
        $this->bookmarkListCollectionFactory = $bookmarkListCollectionFactory;
        $this->searchResultFactory = $searchResultFactory;
        $this->collectionProcessor = $collectionProcessor;
    }

    public function getById($bookmarkListId)
    {
        $bookmarkList = $this->bookmarkListModelFactory->create();
        $this->bookmarkListResource->load($bookmarkList, $bookmarkListId);
        if (!$bookmarkList->getId()) {
            throw new NoSuchEntityException(__('Bookmark List with id "%1" does not exist.', $bookmarkList));
        }
        return $bookmarkList;
    }

    public function save(BookmarkListInterface $bookmarkList)
    {
        try {
            $this->bookmarkListResource->save($bookmarkList);
        } catch (\Exception $exception) {
            throw new CouldNotSaveException(__($exception->getMessage()));
        }
        return $bookmarkList;
    }

    public function delete(BookmarkListInterface $bookmarkList)
    {
        try {
            $this->bookmarkListResource->delete($bookmarkList);
        } catch (\Exception $exception) {
            throw new CouldNotDeleteException(__($exception->getMessage()));
        }
        return true;
    }

    public function getList(SearchCriteriaInterface $searchCriteria)
    {
        /** @var \Inchoo\ProductBookmark\Model\ResourceModel\BookmarkList\Collection $collection */
        $collection = $this->bookmarkListCollectionFactory->create();

        $this->collectionProcessor->process($searchCriteria, $collection);

        /** @var BookmarkListSearchResultsInterface $searchResults */
        $searchResults = $this->searchResultFactory->create();
        $searchResults->setSearchCriteria($searchCriteria);
        $searchResults->setItems($collection->getItems());
        $searchResults->setTotalCount($collection->getSize());
        return $searchResults;
    }
}
