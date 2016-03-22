<?php
namespace Scraper;

class CartPage extends Page {
    
    private $_products;
    
    public function getProductUrls()
    {
        $links = $this->getDom()->query('.productInfo > h3 > a');
        $urls = [];
        foreach($links as $link) {
            $urls[] = $link->href;
        }
        
        return $urls;
    }
    
    public function getProducts()
    {
        if(!$this->_products) {
            $urls = $this->getProductUrls();
            $this->_products = [];
            foreach($urls as $url) {
                $this->_products[] = new ProductPage($url, $this->_client());
            }   
        }
        
        return $this->_products;
    }
    
    public function getTotal()
    {
        $products = $this->getProducts();
        $total = 0;
        foreach($products as $product) {
            $total += $product->getUnitPrice();
        }
        
        return $total;
    }
}