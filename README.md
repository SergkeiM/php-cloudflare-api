# PHP Client for Cloudflare API

A simple PHP Client for [Cloudflare API](https://developers.cloudflare.com/api/).

![Banner](https://repository-images.githubusercontent.com/839240046/29efc427-1f2c-4248-9b1f-b006699d344b)

<p align="center">
    <a href="https://github.com/sergkeim/php-cloudflare-api/actions?query=workflow%3ATests">
        <img src="https://img.shields.io/github/actions/workflow/status/sergkeim/php-cloudflare-api/tests.yml?label=Tests&style=flat-square" alt="Build Status"/>
    </a>
    <a href="LICENSE">
        <img src="https://img.shields.io/badge/license-MIT-brightgreen?style=flat-square" alt="Software License"/>
    </a>
    <a href="https://packagist.org/packages/sergkeim/php-cloudflare-api">
        <img src="https://img.shields.io/packagist/dt/sergkeim/php-cloudflare-api?style=flat-square" alt="Packagist Downloads"/>
    </a>
    <a href="https://github.com/sergkeim/php-cloudflare-api/releases">
        <img src="https://img.shields.io/github/release/sergkeim/php-cloudflare-api?style=flat-square" alt="Latest Version"/>
    </a>
</p>

> **Note**: This package is under active development as I expand it to cover Cloudflare API. Consider the public API of this package a little unstable as I work towards a v1.0. [See Coverage](https://php-cloudflare-api.nuxt.space/coverage)

This package provides convenient access to the Cloudflare REST API using PHP.

- [☁️ Cloudflare API v4](https://developers.cloudflare.com/api/)
- [📄 Documentation](https://php-cloudflare-api.nuxt.space/)
- [📓 Coverage](https://php-cloudflare-api.nuxt.spacee/coverage)

## Features ✨

* PHP >= 8.0
* Minimal API around the [Guzzle HTTP client](https://github.com/guzzle/guzzle)
* Light and fast thanks to lazy loading of API classes
* Extensively documented
* Laravel >= 9 support

## Quick install 🚀

Via [Composer](https://getcomposer.org).

This command will get you up and running quickly.

```bash
composer require sergkeim/php-cloudflare-api
```

## Thanks 🙏

* Thanks to [Cloudflare](https://developers.cloudflare.com/api/) for the high quality API and documentation.
* Thanks to [KnpLabs](https://github.com/KnpLabs) for [php-github-api](https://github.com/KnpLabs/php-github-api) used as inspiration for this package.
* Thanks to [Graham Campbell](https://github.com/GrahamCampbell) for [Laravel TestBench](https://github.com/GrahamCampbell/Laravel-TestBench).

## License 📎

`php-cloudflare-api` is licensed under the MIT License - see the [LICENSE](./LICENSE) file for details

---

Cloudflare, the Cloudflare logo, and Cloudflare Workers are trademarks and/or registered trademarks of Cloudflare, Inc. in the United States and other jurisdictions.