# Webscale CacheManager

Module flushes the Webscale cache for all URLs from Magento

## Installation

### Composer

```bash
composer config repositories.webscale git git@github.com:harshadawebscale/Webscale_CacheManager.git
composer require webscale/cachemanager

php bin/magento module:enable Webscale_CacheManager
php bin/magento setup:upgrade
```

### Manual
To install this package please follow below steps:

1. Upload the content of zip file to app/code/Webscale/CacheManager
2. Enable the module using the command 'bin/magento module:enable Webscale_CacheManager'
3. Run setup upgrade 'php bin/magento setup:upgrade'

## Configuration

1. Go to your admin panel in Store >> Configuration >> Webscale
2. There are 3 fields that need to be filled in as of now:
    a. API Token. For this you need to go to https://control.webscale.com/dashboard >> click on the profile icon >> create a new api token and copy the key
    b. Query String - Not applicable
    c. Application ID (Webscale portal) : this is your application id that is displayed on the dashboard or can also be created from control panel application URL. Connect with Webscale to understand and update this value.

## Authors

* [Webscale](mailto:harshada@webscalenetworks.com)

### Contributors

* [Serhii Koval](mailto:sergiy.koval@gmail.com)
