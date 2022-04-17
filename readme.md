### Checking an arbitrary URL for Micro-Framework HLEB


The class `RouteFinder` is not included in the original configuration of the framework [HLEB](https://github.com/phphleb/hleb), so it must be copied to the folder with the vendor/phphleb  libraries from the [github.com/phphleb/rfinder](https://github.com/phphleb/rfinder)  repository or installed using Composer:

 ```bash
 $ composer require phphleb/rfinder
 ```

Checking:
 ```php
use Phphleb\Rfinder\RouteFinder;

if ((new RouteFinder('/example/url/address/', 'GET'))->isFound()) {
  // Found a match in all types of routes.
}
```
Separately:
 ```php
use Phphleb\Rfinder\RadjaxRouteFinder;
use Phphleb\Rfinder\StandardRouteFinder;

$address = '/example/url/address/';

// Step 1
if ((new RadjaxRouteFinder($address))->isFound()) {
  // Found a match in the Radjax routes.
}

// Step 2
if ((new StandardRouteFinder($address, 'GET'))->isFound()) {
  // Found a match in the standard routes.
}


```

-----------------------------------

[![License: MIT](https://img.shields.io/badge/License-MIT%20(Free)-brightgreen.svg)](https://github.com/phphleb/draft/blob/main/LICENSE) ![PHP](https://img.shields.io/badge/PHP-7-blue) ![PHP](https://img.shields.io/badge/PHP-8-blue) ![PHP](https://img.shields.io/badge/HLEB%20Framework->=1.5.73-brightgreen)

