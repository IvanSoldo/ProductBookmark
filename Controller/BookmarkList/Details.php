<?php


namespace Inchoo\ProductBookmark\Controller\BookmarkList;

use Inchoo\ProductBookmark\Api\BookmarkListRepositoryInterface;
use Inchoo\ProductBookmark\Controller\Bookmark;
use Magento\Customer\Model\Session;
use Magento\Framework\App\Action\Context;
use Magento\Framework\Controller\ResultFactory;

class Details extends Bookmark
{
    private $bookmarkListRepository;

    public function __construct(Context $context, Session $customerSession, BookmarkListRepositoryInterface $bookmarkListRepository)
    {
        parent::__construct($context, $customerSession);
        $this->bookmarkListRepository = $bookmarkListRepository;
    }

    public function execute()
    {

        try {
            $bookmarkList = $this->bookmarkListRepository->getById($this->getRequest()->getParam('id'));
        } catch (\Exception $exception) {
            $this->messageManager->addErrorMessage(__('Something went wrong!'));
            return $this->redirectToList();
        }

        if (!$this->checkOwner($bookmarkList->getCustomerId())) {
            $this->messageManager->addErrorMessage(__('Something went wrong!'));
            return $this->redirectToList();
        }

        return $this->resultFactory->create(ResultFactory::TYPE_PAGE);
    }
}
