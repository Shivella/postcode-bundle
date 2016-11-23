ApiWise Postcode Bundle
=======================

..

Installation
------------
Installation is a quick 3 step process:

1. Download postcode-bundle using composer
2. Enable the Bundle in AppKernel.php
3. Configure ApiWise credentials

### Step 1: Download postcode-bundle using composer

Add UsoftPostcodeBundle by running the command:

``` bash
$ composer require shivella/postcode-bundle
```

### Step 2: Enable the Bundle in AppKernel.php


``` php
<?php
// app/AppKernel.php

public function registerBundles()
{
    $bundles = array(
        // ...
        new Usoft\PostcodeBundle\UsoftPostcodeBundle(),
    );
}
```

### Step 3: Configure ApiWise credentials
```yaml
# app/config/config.yml

# ApiWise Postcode API
usoft_postcode:
    apiwise:
        key: secret_api_wise_key

```
