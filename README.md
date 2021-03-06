[![GitHub tag](https://img.shields.io/github/tag/balazscsaba2006/socially.svg)](https://github.com/balazscsaba2006/socially/tags) * [![Build Status](https://travis-ci.org/balazscsaba2006/socially.svg?branch=master)](https://travis-ci.org/balazscsaba2006/socially) * [![codecov](https://codecov.io/gh/balazscsaba2006/socially/branch/master/graph/badge.svg)](https://codecov.io/gh/balazscsaba2006/socially) * [![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/balazscsaba2006/socially/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/balazscsaba2006/socially/?branch=master) * [![StyleCI Badge](https://styleci.io/repos/171828152/shield)](https://styleci.io/repos/171828152/)

# Socially
Library to validate and parse social media profile URLs.

Currently supported social media platforms:
* Linkedin
* Github
* Twitter
* Google Plus
* Pinterest
* Facebook
* AngelList
* Gravatar
* Klout
* Behance
* Bitbucket
* Dribbble
* Flickr
* Stackoverflow
* Reddit
* Quora

## Requirements

- [PHP](https://secure.php.net/): >= 7.1
- PHP extensions:
  * mbstring
  * json
- [layershifter/tld-extract](https://github.com/layershifter/TLDExtract): ^2.0

## Installation

The recommended way is using **[Composer](https://getcomposer.org/)**. You also can **[download the latest release](https://github.com/balazscsaba2006/socially/releases)** and 
start from there.

### Composer

If you don’t have Composer installed, follow the [installation instructions](https://getcomposer.org/doc/00-intro.md#installation-linux-unix-osx).

Once composer is installed, execute the following command in your project root to install this library:

```sh
composer require balazscsaba2006/socially
```

Finally, remember to include the autoloader to your project:

```php
require __DIR__ . '/vendor/autoload.php';
```

## Usage

```php
$parser = = new Parser();
$result = $parser->isSocialMediaProfile($url);
```

For more examples on usage take a look at the `/tests` directory.

## Contributing
I’d be happy if you contribute to this library. Please try to follow the existing coding style and use proper comments in your commit message. Thanks! 🙇 

## License

Please see the [license file](https://github.com/balazscsaba2006/socially/blob/master/LICENSE) for more information.
