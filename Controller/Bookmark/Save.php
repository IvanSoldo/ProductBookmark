<?php


namespace Inchoo\ProductBookmark\Controller\Bookmark;


use Inchoo\ProductBookmark\Api\BookmarkListRepositoryInterface;
use Inchoo\ProductBookmark\Api\BookmarkRepositoryInterface;
use Inchoo\ProductBookmark\Api\Data\BookmarkInterface;
use Inchoo\ProductBookmark\Api\Data\BookmarkInterfaceFactory;
use Inchoo\ProductBookmark\Controller\Bookmark;
use Magento\Customer\Model\Session;
use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Framework\App\Action\Context;
use Magento\Framework\Data\Form\FormKey\Validator;
use Magento\Store\Model\StoreManagerInterface;

class Save extends Bookmark
{

    private $bookmarkRepository;

    private $bookmarkModelFactory;

    private $storeManager;

    private $validator;

    private $searchCriteriaBuilder;
    /**
     * @var BookmarkListRepositoryInterface
     */
    private $bookmarkListRepository;

    public function __construct(
        Context $context,
        Session $customerSession,
        BookmarkRepositoryInterface $bookmarkRepository,
        BookmarkInterfaceFactory $bookmarkModelFactory,
        StoreManagerInterface $storeManager,
        Validator $validator,
        SearchCriteriaBuilder $searchCriteriaBuilder,
        BookmarkListRepositoryInterface $bookmarkListRepository
    )
    {
        parent::__construct($context, $customerSession);
        $this->bookmarkRepository = $bookmarkRepository;
        $this->bookmarkModelFactory = $bookmarkModelFactory;
        $this->storeManager = $storeManager;
        $this->validator = $validator;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
        $this->bookmarkListRepository = $bookmarkListRepository;
    }

    public function execute()
    {
        if (!$this->validator->validate($this->getRequest())) {
            return $this->redirectToList();
        }

        $bookmarkListId = $this->getRequest()->getParam('bookmarkList');
        $productId = $this->getRequest()->getParam('product');
        $websiteId = $this->storeManager->getStore()->getWebsiteId();

        try {
            $bookmarkList = $this->bookmarkListRepository->getById($bookmarkListId);
        } catch (\Exception $exception) {
            $this->messageManager->addErrorMessage(__('Product could not be saved!'));
            return $this->redirectToList();
        }

        $bookmark = $this->bookmarkModelFactory->create();
        $bookmark->setBookmarkListId($bookmarkListId);
        $bookmark->setProductId($productId);
        $bookmark->setWebsiteId($websiteId);

        if (!$this->checkBookmark($bookmark)) {
            $this->messageManager->addErrorMessage(__('Product already bookmarked!'));
            return $this->redirectToList();
        }

        if (!$this->checkOwner($bookmarkList->getCustomerId())) {
            $this->messageManager->addErrorMessage(__('Product could not be bookmarked!'));
            return $this->redirectToList();
        }

        try {
            $this->bookmarkRepository->save($bookmark);
        } catch (\Exception $exception) {
            $this->messageManager->addErrorMessage(__('Product could not be bookmarked!'));
            return $this->redirectToList();
        }

        $this->messageManager->addSuccessMessage(__('Bookmark added!'));
        return $this->redirectToList();
    }

    private function checkBookmark($bookmark){
        $this->searchCriteriaBuilder
            ->addFilter(BookmarkInterface::PRODUCT_ID, $bookmark->getProductId(), 'eq')
            ->addFilter(BookmarkInterface::WEBSITE_ID, $bookmark->getWebsiteId(), 'eq')
            ->addFilter(BookmarkInterface::BOOKMARK_LIST_ID, $bookmark->getBookmarkListId(), 'eq');
        $searchCriteria = $this->searchCriteriaBuilder->create();

        if (count($this->bookmarkRepository->getList($searchCriteria)->getItems()) > 0) {
            return false;
        }
        return true;
    }
}
