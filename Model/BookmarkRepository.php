<?php

namespace Inchoo\ProductBookmark\Model;

use Inchoo\ProductBookmark\Api\BookmarkRepositoryInterface;
use Inchoo\ProductBookmark\Api\Data\BookmarkInterface;
use Inchoo\ProductBookmark\Api\Data\BookmarkSearchResultsInterface;
use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;

class BookmarkRepository implements BookmarkRepositoryInterface
{

    /**
     * @var \Inchoo\ProductBookmark\Api\Data\BookmarkInterfaceFactory
     */
    protected $bookmarkModelFactory;

    /**
     * @var \Inchoo\ProductBookmark\Model\ResourceModel\Bookmark
     */
    protected $bookmarkResource;

    /**
     * @var \Inchoo\ProductBookmark\Model\ResourceModel\Bookmark\CollectionFactory
     */
    protected $bookmarkCollectionFactory;

    /**
     * @var \Inchoo\ProductBookmark\Api\Data\BookmarkSearchResultsInterfaceFactory
     */
    protected $searchResultFactory;

    /**
     * @var CollectionProcessorInterface
     */
    private $collectionProcessor;

    public function __construct(
        \Inchoo\ProductBookmark\Api\Data\BookmarkInterfaceFactory $bookmarkModelFactory,
        \Inchoo\ProductBookmark\Model\ResourceModel\Bookmark $bookmarkResource,
        \Inchoo\ProductBookmark\Model\ResourceModel\Bookmark\CollectionFactory $bookmarkCollectionFactory,
        \Inchoo\ProductBookmark\Api\Data\BookmarkSearchResultsInterfaceFactory $searchResultFactory,
        CollectionProcessorInterface $collectionProcessor
    )
    {
        $this->bookmarkModelFactory = $bookmarkModelFactory;
        $this->bookmarkResource = $bookmarkResource;
        $this->bookmarkCollectionFactory = $bookmarkCollectionFactory;
        $this->searchResultFactory = $searchResultFactory;
        $this->collectionProcessor = $collectionProcessor;
    }

    public function getById($bookmarkId)
    {
        $bookmark = $this->bookmarkModelFactory->create();
        $this->bookmarkResource->load($bookmark, $bookmarkId);
        if (!$bookmark->getId()) {
            throw new NoSuchEntityException(__('Bookmark with id "%1" does not exist.', $bookmark));
        }
        return $bookmark;
    }

    public function save(BookmarkInterface $bookmark)
    {
        try {
            $this->bookmarkResource->save($bookmark);
        } catch (\Exception $exception) {
            throw new CouldNotSaveException(__($exception->getMessage()));
        }
        return $bookmark;
    }

    public function delete(BookmarkInterface $bookmark)
    {
        try {
            $this->bookmarkResource->delete($bookmark);
        } catch (\Exception $exception) {
            throw new CouldNotDeleteException(__($exception->getMessage()));
        }
        return true;
    }

    public function getList(SearchCriteriaInterface $searchCriteria)
    {
        /** @var \Inchoo\ProductBookmark\Model\ResourceModel\Bookmark\Collection $collection */
        $collection = $this->bookmarkCollectionFactory->create();
        $this->collectionProcessor->process($searchCriteria, $collection);
        /** @var BookmarkSearchResultsInterface $searchResults */
        $searchResults = $this->searchResultFactory->create();
        $searchResults->setSearchCriteria($searchCriteria);
        $searchResults->setItems($collection->getItems());
        $searchResults->setTotalCount($collection->getSize());
        return $searchResults;
    }
}
