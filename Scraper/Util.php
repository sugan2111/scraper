<?php
namespace Scraper;

class Util {
    
    public static function formatPrice($price, $precision = 2)
    {
        return number_format($price, $precision);
    }
    
    public static function formatSize($size, $precision = 2)
    {
        $base = log($size, 1024);
        $suffixes = ['', 'KB', 'MB', 'GB', 'TB'];   

        return number_format(pow(1024, $base - floor($base)), $precision) .' '. $suffixes[floor($base)];
    }
}