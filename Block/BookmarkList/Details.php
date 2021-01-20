<?php

namespace Inchoo\ProductBookmark\Block\BookmarkList;

use Inchoo\ProductBookmark\Api\BookmarkRepositoryInterface;
use Inchoo\ProductBookmark\Api\Data\BookmarkInterface;
use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\Customer\Model\Session;
use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Framework\View\Element\Template;

class Details extends Template
{

    private $bookmarkRepository;

    private $session;

    private $searchCriteriaBuilder;

    private $productRepository;

    public function __construct(
        BookmarkRepositoryInterface $bookmarkRepository,
        Session $session,
        SearchCriteriaBuilder $searchCriteriaBuilder,
        ProductRepositoryInterface $productRepository,
        Template\Context $context,
        array $data = [])
    {
        $this->bookmarkRepository = $bookmarkRepository;
        $this->session = $session;
        parent::__construct($context, $data);
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
        $this->productRepository = $productRepository;
    }

    public function getBookmarkedProducts()
    {
        $this->searchCriteriaBuilder->addFilter(BookmarkInterface::BOOKMARK_LIST_ID, $this->getRequest()->getParam('id'),'eq');
        $searchCriteria = $this->searchCriteriaBuilder->create();
        $bookmarks = $this->bookmarkRepository->getList($searchCriteria)->getItems();
        $products = [];
        foreach ($bookmarks as $bookmark) {
            $products[] = $this->productRepository->getById($bookmark->getProductId());
        }
        return $products;
    }



}