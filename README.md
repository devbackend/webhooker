# BitBucket webhook handlers

## Overview

This is library for handling bitbucket webhook info. It get raw webhook data from request body and generate object with interfaces for most entities of bitbucket.
 
## Installation
The recommended way to install the SDK is with [Composer](https://getcomposer.org/). Composer is a dependency management tool for PHP that allows you to declare the dependencies your project needs and installs them into your project.
 
```bash
/path/to/php /path/to/composer.phar require devbackend/webhooker
```

If composer install globally in your system, you can run next command:

```bash
composer require devbackend/webhooker
```

Alternatively, you can specify the SDK as a dependency in your project's existing composer.json file:
```json
{
    "require" : {
        "devbackend/webhooker": "^1.0" 
    }
}
```

After installing, you need to require Composer's autoloader:

```php
require vendor/autoload.php;
```

And create instance of webhook handler:
```php
$webhookHandler = \Webhooker\PushWebhookHandler::init();

$webHook    = $webhookHandler->getWebhook(); // return an object of interface PushWebhook
$rawWebhook = $webhookHandler->getRaw();     // return raw, unparsed, json-encoded webhook string 
```
