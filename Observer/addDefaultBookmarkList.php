<?php

namespace Inchoo\ProductBookmark\Observer;

use Inchoo\ProductBookmark\Api\BookmarkListRepositoryInterface;
use Inchoo\ProductBookmark\Api\Data\BookmarkListInterfaceFactory;
use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;

class addDefaultBookmarkList implements ObserverInterface
{

    private $bookmarkListModelFactory;

    private $bookmarkListRepository;

    public function __construct(BookmarkListInterfaceFactory $bookmarkListModelFactory, BookmarkListRepositoryInterface $bookmarkListRepository)
    {
        $this->bookmarkListModelFactory = $bookmarkListModelFactory;
        $this->bookmarkListRepository = $bookmarkListRepository;
    }

    public function execute(Observer $observer)
    {
        $customer = $observer->getEvent()->getCustomer();
        $bookmarkList = $this->bookmarkListModelFactory->create();
        $bookmarkList->setBookmarkListTitle("Default");
        $bookmarkList->setIsDeletable(0);
        $bookmarkList->setCustomerId($customer->getId());
        $this->bookmarkListRepository->save($bookmarkList);

    }
}
