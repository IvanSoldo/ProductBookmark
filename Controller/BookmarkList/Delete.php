<?php

namespace Inchoo\ProductBookmark\Controller\BookmarkList;

use Inchoo\ProductBookmark\Api\BookmarkListRepositoryInterface;
use Inchoo\ProductBookmark\Controller\Bookmark;
use Magento\Customer\Model\Session;
use Magento\Framework\App\Action\Context;


class Delete extends Bookmark
{

    private $bookmarkListRepository;

    public function __construct(Context $context, Session $customerSession, BookmarkListRepositoryInterface $bookmarkListRepository)
    {
        parent::__construct($context, $customerSession);
        $this->bookmarkListRepository = $bookmarkListRepository;
    }

    public function execute()
    {
        $bookmarkList = $this->checkBookmarkList($this->getRequest()->getParam('id'));
        if (!$bookmarkList) {
            return $this->redirectToList();
        }
        if ($bookmarkList->getIsDeletable() == 0) {
            $this->messageManager->addErrorMessage(__('Default list cannot be deleted!'));
            return $this->redirectToList();
        }
        $this->bookmarkListRepository->delete($bookmarkList);
        $this->messageManager->addSuccessMessage(__('Bookmark List deleted!'));

        return $this->redirectToList();
    }

    private function checkBookmarkList($id)
    {
        $bookmarkList = "";
        try {
            $customerId = $this->customerSession->getId();
            $bookmarkList = $this->bookmarkListRepository->getById($id);

            if ($bookmarkList->getCustomerId() !== $customerId) {
                $this->messageManager->addErrorMessage(__('Something went wrong!'));
                return false;
            }
        } catch (\Exception $exception) {
            $this->messageManager->addErrorMessage(__('Something went wrong!'));
            return false;
        }

        return $bookmarkList;
    }
}
