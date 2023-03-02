<?php
/**
 * Copyright © Webscale Networks
 */
declare(strict_types = 1);

namespace Webscale\CacheManager\Observer;

use Magento\Framework\App\Cache\Tag\Resolver;
use Magento\Framework\Event\Observer;
use Magento\Framework\HTTP\Client\Curl;
use Webscale\CacheManager\Model\Config;

class FlushByTags implements \Magento\Framework\Event\ObserverInterface
{
    /**
     * @var Curl
     */
    protected $_curl;

    /**
     * @var Resolver
     */
    private $tagResolver;

    /**
     * @var Config
     */
    private $config;

    /**
     * Constructor
     *
     * @param Curl     $curl
     * @param Config   $config
     * @param Resolver $tagResolver
     */

    public function __construct(
        Curl $curl,
        Config $config,
        Resolver $tagResolver
    ) {
        $this->_curl = $curl;
        $this->config = $config;
        $this->tagResolver = $tagResolver;
    }

    /**
     * Flush By Tags
     *
     * @param Observer $observer
     *
     * @return void
     */
    public function execute(Observer $observer)
    {
        $object = $observer->getEvent()->getObject();
        if (!is_object($object)) {
            return;
        }
        $tags = $this->tagResolver->getTags($object);

        $token = $this->config->getToken();
        $appName = $this->config->getAppName();

        if (!empty($tags)) {
            $finalTags = array_unique($tags);
            $otherTags = json_encode($finalTags);

            try {
                $data = '{"type":"invalidate-cache","target":"/v2/applications/' . $appName
                    . '","parameters":{"urls":["*://*\/*"],"tags":' . $otherTags . '}}';
                $url = $this->config->getApiUrl();
                $this->_curl->addHeader("Content-Type", "application/json");
                $this->_curl->addHeader("Authorization", "Bearer $token");
                $this->_curl->addHeader("Accept", "application/json");
                $this->_curl->post($url, $data);
                //response will contain the output in form of JSON string
                $response = $this->_curl->getBody();
               // $responseArr = $response->__toArray();
               // print_r($response);
            } catch (\Exception $e) {
               print($e);
            }
        }
            //print_r($othertags);
            //die();
            //$site_tags =implode(",",$final_tags);

            //$site_tags = sprintf("'%s'", implode("','", $final_tags ) );

          //  echo "Site tags".print_r($site_tags);
    }
}
