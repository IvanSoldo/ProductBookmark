<?php

namespace Inchoo\ProductBookmark\Block\BookmarkList;

use Inchoo\ProductBookmark\Api\BookmarkListRepositoryInterface;
use Inchoo\ProductBookmark\Api\Data\BookmarkListInterface;
use Magento\Customer\Model\Session;
use Magento\Framework\Api\FilterBuilder;
use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Framework\View\Element\Template\Context;
use Magento\Framework\View\Element\Template;


class BookmarkList extends Template
{

    private $searchCriteriaBuilder;

    private $bookmarkListRepository;

    private $session;

    private $filterBuilder;


    public function __construct(
        SearchCriteriaBuilder $searchCriteriaBuilder,
        BookmarkListRepositoryInterface $bookmarkListRepository,
        Session $session,
        FilterBuilder $filterBuilder,
        Context $context,
        array $data = []
    )
    {
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
        $this->bookmarkListRepository = $bookmarkListRepository;
        $this->session = $session;
        $this->filterBuilder = $filterBuilder;
        parent::__construct($context, $data);
    }

    public function getBookmarkLists()
    {
        $this->searchCriteriaBuilder->addFilter(BookmarkListInterface::CUSTOMER_ID, $this->session->getCustomerId(),'eq');
        $searchCriteria = $this->searchCriteriaBuilder->create();

        return $this->bookmarkListRepository->getList($searchCriteria)->getItems();


    }

    public function getNewUrl() {
        return $this->getUrl('inchoo_bookmark/bookmarklist/new');
    }

    public function getDeleteUrl($id) {
        return $this->getUrl('inchoo_bookmark/bookmarklist/delete', ['id' => $id]);
    }

    public function getDetailsUrl($id) {
        return $this->getUrl('inchoo_bookmark/bookmarklist/details', ['id' => $id]);
    }
}
