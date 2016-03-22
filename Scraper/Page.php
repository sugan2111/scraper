<?php
namespace Scraper;
use GuzzleHttp\Client;
use pQuery;

abstract Class Page {
    private $_url, $_resp, $_dom, $_client;
    
    public function __construct($url, $client = null)
    {
        $this->_url = $url;
        
        if($client) {
            $this->_client = $client;
        }
    }
    
    protected function _client()
    {
        if(!$this->_client) {
            $this->_client = new Client();
        }
        
        return $this->_client;
    }
    
    public function getResp()
    {
        if(!$this->_resp) {
            $this->_resp = $this->_client()->request('GET', $this->_url);    
        }
        return $this->_resp;
    }
    
    public function getBody()
    {
        return (String) $this->getResp()->getBody();
    }
    
    public function getSize()
    {
        return $this->getResp()->getHeader('Content-Length')[0];
    }
    
    public function getDom()
    {
        if(! $this->_dom ) {
            $this->_dom = pQuery::parseStr($this->getBody());
        }
        
        return $this->_dom;
    }
    
}