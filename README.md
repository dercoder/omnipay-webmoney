# Omnipay: WebMoney

**WebMoney driver for the Omnipay PHP payment processing library**

[![Build Status](https://app.travis-ci.com/dercoder/omnipay-webmoney.svg?branch=master)](https://app.travis-ci.com/github/dercoder/omnipay-webmoney)
[![Coverage Status](https://coveralls.io/repos/dercoder/omnipay-webmoney/badge.svg?branch=master&service=github)](https://coveralls.io/github/dercoder/omnipay-webmoney?branch=master)

[![Latest Stable Version](https://img.shields.io/packagist/v/dercoder/omnipay-webmoney)](https://packagist.org/packages/dercoder/omnipay-webmoney)
[![Total Downloads](https://img.shields.io/packagist/dt/dercoder/omnipay-webmoney)](https://packagist.org/packages/dercoder/omnipay-webmoney)
[![License](https://img.shields.io/packagist/l/dercoder/omnipay-webmoney)](https://packagist.org/packages/dercoder/omnipay-webmoney)

[Omnipay](https://github.com/omnipay/omnipay) is a framework agnostic, multi-gateway payment
processing library for PHP 7.0+. This package implements [WebMoney](https://www.webmoney.az) support for Omnipay.

## Installation

Omnipay is installed via [Composer](http://getcomposer.org/). To install, simply add it
to your `composer.json` file:

```json
{
    "require": {
        "dercoder/omnipay-webmoney": "^5.0"
    }
}
```

And run composer to update your dependencies:

    $ curl -s http://getcomposer.org/installer | php
    $ php composer.phar update

## Basic Usage

The following gateways are provided by this package:

* WebMoney

For general usage instructions, please see the main [Omnipay](https://github.com/omnipay/omnipay)
repository.

## Support

If you are having general issues with Omnipay, we suggest posting on
[Stack Overflow](http://stackoverflow.com/). Be sure to add the
[omnipay tag](http://stackoverflow.com/questions/tagged/omnipay) so it can be easily found.

If you want to keep up to date with release anouncements, discuss ideas for the project,
or ask more detailed questions, there is also a [mailing list](https://groups.google.com/forum/#!forum/omnipay) which
you can subscribe to.

If you believe you have found a bug, please report it using the [GitHub issue tracker](https://github.com/dercoder/omnipay-webmoney/issues),
or better yet, fork the library and submit a pull request.
