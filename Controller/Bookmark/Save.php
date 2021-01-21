<?php


namespace Inchoo\ProductBookmark\Controller\Bookmark;


use Inchoo\ProductBookmark\Api\BookmarkRepositoryInterface;
use Inchoo\ProductBookmark\Api\Data\BookmarkInterfaceFactory;
use Inchoo\ProductBookmark\Controller\Bookmark;
use Magento\Customer\Model\Session;
use Magento\Framework\App\Action\Context;
use Magento\Framework\Data\Form\FormKey\Validator;
use Magento\Store\Model\StoreManagerInterface;

class Save extends Bookmark
{

    private $bookmarkRepository;

    private $bookmarkModelFactory;

    private $storeManager;

    private $validator;

    public function __construct(
        Context $context,
        Session $customerSession,
        BookmarkRepositoryInterface $bookmarkRepository,
        BookmarkInterfaceFactory $bookmarkModelFactory,
        StoreManagerInterface $storeManager,
        Validator $validator
    )
    {
        parent::__construct($context, $customerSession);
        $this->bookmarkRepository = $bookmarkRepository;
        $this->bookmarkModelFactory = $bookmarkModelFactory;
        $this->storeManager = $storeManager;
        $this->validator = $validator;
    }

    public function execute()
    {
        if (!$this->validator->validate($this->getRequest())) {
            return $this->redirectToList();
        }

        $bookmarkListId = $this->getRequest()->getParam('bookmarkList');
        $productId = $this->getRequest()->getParam('product');
        $websiteId = $this->storeManager->getStore()->getWebsiteId();
        $bookmark = $this->bookmarkModelFactory->create();
        $bookmark->setBookmarkListId($bookmarkListId);
        $bookmark->setProductId($productId);
        $bookmark->setWebsiteId($websiteId);
        $this->bookmarkRepository->save($bookmark);

        $this->messageManager->addSuccessMessage(__('Bookmark added!'));
        return $this->redirectToList();
    }

    private function checkBookmark($bookmark){

    }
}
