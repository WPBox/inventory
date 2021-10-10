<?php

/*
 * HTML5 DOMDocument PHP library (extends DOMDocument)
 * https://github.com/ivopetkov/html5-dom-document-php
 * Copyright (c) Ivo Petkov
 * Free to use under the MIT license.
 */

$classes = array(
    'MediaCloud\Vendor\IvoPetkov\HTML5DOMDocument' => __DIR__ . '/src/HTML5DOMDocument.php',
    'MediaCloud\Vendor\IvoPetkov\HTML5DOMDocument\Internal\QuerySelectors' => __DIR__ . '/src/HTML5DOMDocument/Internal/QuerySelectors.php',
    'MediaCloud\Vendor\IvoPetkov\HTML5DOMElement' => __DIR__ . '/src/HTML5DOMElement.php',
    'MediaCloud\Vendor\IvoPetkov\HTML5DOMNodeList' => __DIR__ . '/src/HTML5DOMNodeList.php',
    'MediaCloud\Vendor\IvoPetkov\HTML5DOMTokenList' => __DIR__ . '/src/HTML5DOMTokenList.php'
);

spl_autoload_register(function ($class) use ($classes) {
    if (isset($classes[$class])) {
        require $classes[$class];
    }
});
