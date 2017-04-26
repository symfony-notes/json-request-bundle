# Json Request Bundle
This bundle will help you automatically decode json request.

[![SensioLabsInsight][sensiolabs-insight-image]][sensiolabs-insight-link]

[![License][license-image]][license-link]

Installation
------------
* Require the bundle with composer:

``` bash
composer require symfony-notes/json-request-bundle
```

* Enable the bundle in the kernel:

``` php
public function registerBundles()
{
    $bundles = [
        // ...
        new SymfonyNotes\JsonRequestBundle\SymfonyNotesJsonRequestBundle(),
        // ...
    ];
    ...
}
```

[license-link]: https://github.com/symfony-notes/json-request-bundle/blob/master/LICENSE
[license-image]: https://img.shields.io/dub/l/vibe-d.svg
[sensiolabs-insight-link]: https://insight.sensiolabs.com/projects/9a7946b5-3eec-4b5f-8382-7cb098ada63a
[sensiolabs-insight-image]: https://insight.sensiolabs.com/projects/9a7946b5-3eec-4b5f-8382-7cb098ada63a/big.png
