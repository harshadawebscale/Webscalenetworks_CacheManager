<?php
/**
 * Copyright © Webscale Networks
 */
declare(strict_types = 1);

namespace Webscale\CacheManager\Model;

use Magento\Framework\App\Config\ScopeConfigInterface as ScopeConfig;
use Magento\Store\Model\ScopeInterface as Scope;

class Config
{
    private const XML_PATH_ACTIVE   = 'cachemanager/config/active';
    private const XML_PATH_TOKEN    = 'cachemanager/config/token';
    private const XML_PATH_QUERY    = 'cachemanager/config/query';
    private const XML_PATH_APP_NAME = 'cachemanager/config/app_name';
    private const XML_PATH_API_URL  = 'cachemanager/config/api_url';

    /**
     * @var ScopeConfig
     */
    private $scopeConfig;

    /**
     * @param ScopeConfig $scope
     */
    public function __construct(ScopeConfig $scope)
    {
        $this->scopeConfig = $scope;
    }

    /**
     * Is active?
     *
     * @param $store
     *
     * @return mixed
     */
    public function isActive($store = null): bool
    {
        return $this->scopeConfig->isSetFlag(self::XML_PATH_ACTIVE, Scope::SCOPE_STORES, $store);
    }

    /**
     * Get token
     *
     * @param $store
     *
     * @return mixed
     */
    public function getToken($store = null): string
    {
        return (string)$this->scopeConfig->getValue(self::XML_PATH_TOKEN, Scope::SCOPE_STORES, $store);
    }

    /**
     * Get query
     *
     * @param $store
     *
     * @return string
     */
    public function getQuery($store = null): string
    {
        return (string)$this->scopeConfig->getValue(self::XML_PATH_QUERY, Scope::SCOPE_STORES, $store);
    }

    /**
     * Get App Name
     *
     * @param $store
     *
     * @return string
     */
    public function getAppName($store = null): string
    {
        return (string)$this->scopeConfig->getValue(self::XML_PATH_APP_NAME, Scope::SCOPE_STORES, $store);
    }

    /**
     * Get API Url
     *
     * @return string
     */
    public function getApiUrl(): string
    {
        return (string)$this->scopeConfig->getValue(self::XML_PATH_API_URL);
    }
}
