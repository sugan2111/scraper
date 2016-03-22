<?php

use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Exception\RequestException;


class ScraperTest extends PHPUnit_Framework_TestCase {
    public function setUp()
    {
        $url = 'dummy-url';
        $cartBody = file_get_contents(dirname(__FILE__) . '/../data/cart.html');
        $productBody = file_get_contents(dirname(__FILE__) . '/../data/product.html');
        $mock = new MockHandler([
            new Response(200, ['Content-Length' => 2048], $cartBody),
            new Response(200, ['Content-Length' => 2048], $productBody),
            new Response(200, ['Content-Length' => 2048], $productBody),
            new Response(200, ['Content-Length' => 2048], $productBody),
            new Response(200, ['Content-Length' => 2048], $productBody),
            new Response(200, ['Content-Length' => 2048], $productBody),
            new Response(200, ['Content-Length' => 2048], $productBody),
            new Response(200, ['Content-Length' => 2048], $productBody)
        ]);

        $handler = HandlerStack::create($mock);
        $client = new Client(['handler' => $handler]);
        
        $this->cart = new Scraper\CartPage($url, $client);
    }
    
    public function testProductUrlsCount()
    {
        $urls = $this->cart->getProductUrls();
        $this->assertEquals(7, count($urls));
    }
    
    public function testProductUrls()
    {
        $urls = $this->cart->getProductUrls();
        $this->assertEquals([
            "http://hiring-tests.s3-website-eu-west-1.amazonaws.com/2015_Developer_Scrape/sainsburys-apricot-ripe---ready-320g.html",
            "http://hiring-tests.s3-website-eu-west-1.amazonaws.com/2015_Developer_Scrape/sainsburys-avocado-xl-pinkerton-loose-300g.html",
            "http://hiring-tests.s3-website-eu-west-1.amazonaws.com/2015_Developer_Scrape/sainsburys-avocado--ripe---ready-x2.html",
            "http://hiring-tests.s3-website-eu-west-1.amazonaws.com/2015_Developer_Scrape/sainsburys-avocados--ripe---ready-x4.html",
            "http://hiring-tests.s3-website-eu-west-1.amazonaws.com/2015_Developer_Scrape/sainsburys-conference-pears--ripe---ready-x4-%28minimum%29.html",
            "http://hiring-tests.s3-website-eu-west-1.amazonaws.com/2015_Developer_Scrape/sainsburys-golden-kiwi--taste-the-difference-x4-685641-p-44.html",
            "http://hiring-tests.s3-website-eu-west-1.amazonaws.com/2015_Developer_Scrape/sainsburys-kiwi-fruit--ripe---ready-x4.html"
        ],$urls);
    }
    
    public function testBodySize()
    {
        $this->assertEquals(2048, $this->cart->getSize());
    }
    
    public function testProductCount()
    {
        $products = $this->cart->getProducts();
        $this->assertEquals(7, count($products));
    }
    
    public function testProductInfo()
    {
        $products = $this->cart->getProducts();
        $product = $products[0];
        $this->assertEquals("Sainsbury's Avocados, Ripe & Ready x4", $product->getTitle());
        $this->assertEquals("Avocados", $product->getDescription());
        $this->assertEquals(3.2, $product->getUnitPrice());
        $this->assertEquals(2048, $product->getSize());
    }
    
    public function testTotal()
    {
        $total = $this->cart->getTotal();
        $this->assertEquals(22.4, $total);
    }
    
    public function tearDown()
    {
        $this->cart = null;
    }
}