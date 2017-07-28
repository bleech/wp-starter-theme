# Lorem Ipsum (Flynt Feature)

Shortcodes and helper classes to generate demo content to help with developing using the API from http://loripsum.net/.

## API

**Base URL:**<br />
[http://loripsum.net/api](http://loripsum.net/api)

## Example Shortcode

[lorem-ipsum  length="long" decorate="1" headers="1"]

## Shortcode attributes

* paragraphs: (int)
* length: (short|medium|long|verylong)
* decorate
* link
* ul
* ol
* dl
* quote
* code
* prude
* plaintext

## Function Options

You can also call the function via the helper class.

```php
<?php

use Flynt\Features\LoremIpsum\Helper;

$content = Helper::getLoremIpsum([
  'plength' => 2,
  'length' => 'short',
  'decorate' => false,
  'link' => false,
  'ul' => false,
  'ol' => false,
  'dl' => false,
  'bq' => false,
  'code' => false,
  'prude' => false,
  'plaintext' => false
]);
```