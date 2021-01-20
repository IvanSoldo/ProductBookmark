<?php


namespace Inchoo\ProductBookmark\Controller\BookmarkList;


use Inchoo\ProductBookmark\Api\BookmarkListRepositoryInterface;
use Inchoo\ProductBookmark\Api\Data\BookmarkListInterfaceFactory;
use Inchoo\ProductBookmark\Controller\Bookmark;
use Magento\Customer\Model\Session;
use Magento\Framework\App\Action\Context;
use Magento\Framework\Data\Form\FormKey\Validator;

class NewAction extends Bookmark
{

    private $validator;

    private $bookmarkListModelFactory;

    private $bookmarkListRepository;

    public function __construct(
        Context $context,
        Session $customerSession,
        Validator $validator,
        BookmarkListInterfaceFactory $bookmarkListModelFactory,
        BookmarkListRepositoryInterface $bookmarkListRepository
    )
    {
        parent::__construct($context, $customerSession);
        $this->validator = $validator;
        $this->bookmarkListModelFactory = $bookmarkListModelFactory;
        $this->bookmarkListRepository = $bookmarkListRepository;
    }

    public function execute()
    {
        if (!$this->validator->validate($this->getRequest())) {
            return $this->redirectToList();
        }

        try {
            $customerId = $this->customerSession->getId();
            $title = $this->_request->getParam('title');
            if (empty($title)) {
                $this->messageManager->addErrorMessage('Title must not be empty!');
                return $this->redirectToList();
            }

            $bookmarkList = $this->bookmarkListModelFactory->create();
            $bookmarkList->setBookmarkListTitle($title);
            $bookmarkList->setCustomerId($customerId);
            $this->bookmarkListRepository->save($bookmarkList);

            $this->messageManager->addSuccessMessage(__('Bookmark List created!'));
        } catch (\Exception $exception) {
            $this->messageManager->addErrorMessage(__('Bookmark List not saved!'));
        }
        return $this->redirectToList();
    }
}
