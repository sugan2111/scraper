<?php
require_once dirname(__FILE__) . '/bootstrap.php';

use Scraper\Util;

$uri = 'http://hiring-tests.s3-website-eu-west-1.amazonaws.com/2015_Developer_Scrape/5_products.html';

$cart = new Scraper\CartPage($uri);
$products = $cart->getProducts();

$output = ['results' => [], 'total' => 0];

foreach($products as $product) {
    $output['results'][] = [
        'title' => $product->getTitle(),
        'size' => Util::formatSize($product->getSize()),
        'unit_price' => Util::formatPrice($product->getUnitPrice()),
        'description' => $product->getDescription()
    ];
}

$output['total'] = Util::formatPrice($cart->getTotal());

echo json_encode($output, JSON_PRETTY_PRINT);