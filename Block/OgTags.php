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
            return $product->getData('og_title');
        } elseif ($category = $this->registry->registry('current_category')) {
            return $category->getData('og_title');
        } elseif ($cmsPage = $this->getCmsPage()) {
            return $cmsPage->getData('og_title');
        } elseif ($this->_request->getFullActionName() == 'cms_index_index') {
            return $this->helper->getConfigValue('ogtags/homepage/og_title_home');
        }
        return $this->helper->getConfigValue('ogtags/general/og_title');
    }

    public function getOgImage()
    {
        if ($product = $this->registry->registry('current_product')) {
            return $product->getData('og_image');
        } elseif ($category = $this->registry->registry('current_category')) {
            return $category->getData('og_image');
        } elseif ($cmsPage = $this->getCmsPage()) {
            return $cmsPage->getData('og_image');
        } elseif ($this->_request->getFullActionName() == 'cms_index_index') {
            return $this->helper->getConfigValue('ogtags/homepage/og_image_home');
        }
        return $this->helper->getConfigValue('ogtags/general/og_image');
    }

    private function getCmsPage()
    {
        $pageIdentifier = $this->_request->getFullActionName();
        return $this->_layout->createBlock('Magento\Cms\Block\Page')->getPage();
    }
}
