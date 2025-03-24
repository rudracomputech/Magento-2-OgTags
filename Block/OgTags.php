<?php
namespace Rudracomputech\Ogtags\Block;

use Magento\Framework\View\Element\Template;
use Magento\Framework\Registry;
use Magento\Cms\Model\Page as CmsPage;
use Magento\Catalog\Model\Product;
use Magento\Catalog\Model\Category;
use Rudracomputech\Ogtags\Helper\Data;

class OgTags extends Template
{
    protected $registry;
    protected $helper;

    public function __construct(
        Template\Context $context,
        Registry $registry,
        Data $helper,
        array $data = []
    ) {
        $this->registry = $registry;
        $this->helper = $helper;
        parent::__construct($context, $data);
    }

    public function getOgTitle()
    {
        if ($product = $this->registry->registry('current_product')) {
            return $product->getName();
        } elseif ($category = $this->registry->registry('current_category')) {
            return $category->getName();
        } elseif ($cmsPage = $this->getCmsPage()) {
            return $cmsPage->getTitle();
        }
        return $this->helper->getConfigValue('ogtags/general/og_title');
    }

    public function getOgImage()
    {
        if ($product = $this->registry->registry('current_product')) {
            return $this->getProductImageUrl($product);
        } elseif ($category = $this->registry->registry('current_category')) {
            return $this->getCategoryImageUrl($category);
        }
        return $this->helper->getConfigValue('ogtags/general/og_image');
    }

    private function getProductImageUrl(Product $product)
    {
        $imageHelper = $this->_layout->createBlock('Magento\Catalog\Helper\Image');
        return $imageHelper->init($product, 'product_page_image_medium')->getUrl();
    }

    private function getCategoryImageUrl(Category $category)
    {
        return $category->getImageUrl();
    }

    private function getCmsPage()
    {
        $pageIdentifier = $this->_request->getFullActionName();
        return $this->_layout->createBlock('Magento\Cms\Block\Page')->getPage();
    }
}
