<?php

namespace Inchoo\ProductBookmark\Ui\Component\Listing;

use Inchoo\ProductBookmark\Model\ResourceModel\Bookmark\CollectionFactory as BookmarkCollectionFactory;
use Magento\Catalog\Model\ResourceModel\Product\CollectionFactory;
use Magento\Ui\DataProvider\AbstractDataProvider;

class DataProvider extends AbstractDataProvider
{

    private $bookmarkCollectionFactory;

    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        CollectionFactory $productCollectionFactory,
        BookmarkCollectionFactory $bookmarkCollectionFactory,
        array $meta = [],
        array $data = []
    ) {
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
        $this->collection = $productCollectionFactory->create();
        $this->bookmarkCollectionFactory = $bookmarkCollectionFactory;
    }

    public function getData()
    {
        $bookmarks = $this->bookmarkCollectionFactory->create();

        foreach ($bookmarks as $bookmark) {
            $productIds[] = $bookmark->getProductId();
        }

        $bookmarkCounter = array_count_values($productIds);

        $items = $this
            ->getCollection()
            ->addFieldToFilter('entity_id', $productIds)
            ->toArray();

        $data = [
            'totalRecords' => $this->count(),
            'items' => array_values($items),
        ];

        for ($i = 0; $i<count($data['items']); $i++) {
            $data['items'][$i]['bookmarkCounter'] = $bookmarkCounter[$data['items'][$i]['entity_id']];
        }

        return $data;
    }
}
