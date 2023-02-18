<?php
/**
 * Copyright © Webscale Networks
 * 
 */
namespace Webscale\CacheManager\Observer;

class FlushAllCacheObserver implements \Magento\Framework\Event\ObserverInterface
{

    protected $_curl;

    /**
   * Constructor
   *
   * @param string $url
   * @param \Magento\Framework\HTTP\Adapter\Curl $curl
   */


    public function __construct(
    \Magento\Framework\App\Cache\TypeListInterface $cacheTypeList,
    \Magento\Framework\App\Cache\Frontend\Pool $cacheFrontendPool,
    \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig,
    \Magento\Framework\HTTP\Client\Curl $curl
    ) {
            $this->cacheTypeList = $cacheTypeList;
            $this->cacheFrontendPool = $cacheFrontendPool;
            $this->scopeConfig = $scopeConfig;
            $this->_curl = $curl;
    }

    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        
        $API_token    = $this->scopeConfig->getValue('cachemanager/Setup/token', \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
        $query_search = $this->scopeConfig->getValue('cachemanager/Setup/query', \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
        $app_name     = $this->scopeConfig->getValue('cachemanager/Setup/app_name', \Magento\Store\Model\ScopeInterface::SCOPE_STORE);

       // echo "Values ".$API_token." ".$query_search." ".$app_name;exit;

          $data ='{"type":"invalidate-cache","target":"/v2/applications/'.$app_name.'","parameters":{"urls":["*://*\/*"]}}';
          try{
            $url = 'https://api.webscale.com/v2/tasks';
            $this->_curl->addHeader("Content-Type", "application/json");
            $this->_curl->addHeader("Authorization", "Bearer $API_token");
            $this->_curl->addHeader("Accept", "application/json");
            $this->_curl->post($url,$data);
            //response will contain the output in form of JSON string
            $response = $this->_curl->getBody();
           // $responseArr = $response->__toArray();
           // print_r($response);
        }
        catch (\Exception $e) {
           print($e);
        }
       
    }
} 