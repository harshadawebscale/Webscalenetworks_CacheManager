
To install this package please follow below steps:

1. Upload the content of zip file to app/code
2. Enable the module using the command 'bin/magento module:enable Webscale_CacheManager'
3. Run setup upgrade 'php bin/magento setup:upgrade'
4. Go to your admin panel in Store >> Configuration >> Webscale
5. There are 3 fields that need to be filled in as of now:
    a. API Token. For this you need to go to https://control.webscale.com/dashboard >> click on the profile icon >> create a new api token and copy the key
    b. Query String - Not applicable
    c. Application ID (Webscale portal) : this is your application id that is displayed on the dashboard or can also be created from control panel application URL. Connect with Webscale to understand and update this value.

