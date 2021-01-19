<?php

namespace Inchoo\ProductBookmark\Block;

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

    private $bookmarkListFactory;


    public function __construct(
        SearchCriteriaBuilder $searchCriteriaBuilder,
        BookmarkListRepositoryInterface $bookmarkListRepository,
        Session $session,
        FilterBuilder $filterBuilder,
        Context $context,
        \Inchoo\ProductBookmark\Model\BookmarkListFactory $bookmarkListFactory,
        array $data = []
    )
    {
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
        $this->bookmarkListRepository = $bookmarkListRepository;
        $this->session = $session;
        $this->filterBuilder = $filterBuilder;
        parent::__construct($context, $data);

        $this->bookmarkListFactory = $bookmarkListFactory;
    }

    public function getBookmarkLists()
    {
        return $this->bookmarkListFactory
            ->create()
            ->getCollection()
            ->addFieldToFilter(BookmarkListInterface::CUSTOMER_ID, $this->
            session->getCustomerId());
    }
}
