<?php
/**
 * Copyright © Webscale Networks
 */
declare(strict_types = 1);

namespace Webscalenetworks\CacheManager\Observer;

use Magento\Framework\Event\Observer;
use Magento\Framework\HTTP\Client\Curl;
use Webscalenetworks\CacheManager\Model\Config;

class FlushAllCacheObserver implements \Magento\Framework\Event\ObserverInterface
{
    /**
     * @var Curl
     */
    protected $_curl;

    /**
     * @var Config
     */
    private $config;

    /**
     * Constructor
     *
     * @param Curl   $curl
     * @param Config $config
     */
    public function __construct(
        Curl $curl,
        Config $config
    ) {
        $this->_curl = $curl;
        $this->config = $config;
    }

    /**
     * Flush All Cache
     *
     * @param Observer $observer
     *
     * @return void
     */
    public function execute(Observer $observer)
    {
        if (!$this->config->isActive()) {
            return;
        }

        $token = $this->config->getToken();
        $appName = $this->config->getAppName();

        $data = '{"type":"invalidate-cache","target":"/v2/applications/'
            . $appName . '","parameters":{"urls":["*://*\/*"]}}';
        try {
            $url = $this->config->getApiUrl();
            $this->_curl->addHeader("Content-Type", "application/json");
            $this->_curl->addHeader("Authorization", "Bearer $token");
            $this->_curl->addHeader("Accept", "application/json");
            $this->_curl->post($url, $data);
        } catch (\Exception $e) {
            //Adding an error log message
            $this->logger->error('Error flushing all cache: ' . $e->getMessage());
        }
    }
}
