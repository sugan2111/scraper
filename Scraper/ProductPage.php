<?php
namespace Scraper;

class ProductPage extends Page {
    
    public function getTitle()
    {
        return $this->getDom()->query('h1')->html();
    }
    
    public function getDescription()
    {
        return trim($this->getDom()->query('.productText')->text());
    }
    
    public function getUnitPrice()
    {
        $priceText = $this->getDom()->query('.pricePerUnit')->text();
        $price = str_replace("/unit", "", $priceText);
        $amount = str_replace("£", "", $price);
        return (float) $amount;
    }
    
}