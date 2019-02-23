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
- PHP extension **mbstring**
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
$result = $this->parser->isSocialMediaProfile($url);
```

For more examples on usage take a look at the `/tests` directory.

## Contributing
I’d be happy if you contribute to this library. Please try to follow the existing coding style and use proper comments in your commit message. Thanks! 🙇 

## License

Please see the [license file](https://github.com/balazscsaba2006/socially/blob/master/LICENSE) for more information.
