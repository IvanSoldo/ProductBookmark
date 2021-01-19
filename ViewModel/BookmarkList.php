<?php


namespace Inchoo\ProductBookmark\ViewModel;

use Inchoo\ProductBookmark\Api\BookmarkListRepositoryInterface;
use Inchoo\ProductBookmark\Api\Data\BookmarkListInterface;
use Magento\Customer\Model\Session;
use Magento\Framework\Api\FilterBuilder;
use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Framework\View\Element\Block\ArgumentInterface;

class BookmarkList implements ArgumentInterface
{

    private $searchCriteriaBuilder;

    private $bookmarkListRepository;

    private $session;

    private $filterBuilder;

    public function __construct(
        SearchCriteriaBuilder $searchCriteriaBuilder,
        BookmarkListRepositoryInterface $bookmarkListRepository,
        Session $session,
        FilterBuilder $filterBuilder
    )
    {
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
        $this->bookmarkListRepository = $bookmarkListRepository;
        $this->session = $session;
        $this->filterBuilder = $filterBuilder;
    }

    public function getBookmarkLists()
    {

        $customerId = $this->session->getId();
        $filter = $this->filterBuilder
            ->setField(BookmarkListInterface::CUSTOMER_ID)
            ->setValue($customerId);

        $searchCriteria = $this->searchCriteriaBuilder->create();
        $searchCriteria->setFilterGroups([$filter]);

        return $this->bookmarkListRepository->getList($searchCriteria);
    }

}
