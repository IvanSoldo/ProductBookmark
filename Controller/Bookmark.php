<?php

namespace Inchoo\ProductBookmark\Controller;

use Magento\Customer\Model\Session;
use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\App\RequestInterface;

abstract class Bookmark extends Action
{
    protected $customerSession;

    public function __construct(
        Context $context,
        Session $customerSession
    )
    {
        $this->customerSession = $customerSession;
        parent::__construct($context);
    }

    protected function redirectToList()
    {
        return $this->_redirect('inchoo_bookmark/bookmarklist/index');
    }

    protected function checkOwner($id)
    {
        $customerId = $this->customerSession->getId();
        if ($id !== $customerId) {
            $this->messageManager->addErrorMessage(__('Something went wrong!'));
            return false;
        }
        return true;
    }

    public function dispatch(RequestInterface $request)
    {
        if (!$this->customerSession->authenticate()) {
            $this->_actionFlag->set('', 'no-dispatch', true);
            if (!$this->customerSession->getBeforeUrl()) {
                $this->customerSession->setBeforeUrl($this->
                _redirect->getRefererUrl());
            }
        }
        return parent::dispatch($request);
    }
}
