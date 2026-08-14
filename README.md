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
    <a href="#coverage">
        <img src="https://img.shields.io/badge/Coverage-100%25-brightgreen?style=flat-square" alt="Coverage"/>
    </a>
    <a href="https://packagist.org/packages/sergkeim/php-cloudflare-api">
        <img src="https://img.shields.io/packagist/dt/sergkeim/php-cloudflare-api?style=flat-square" alt="Packagist Downloads"/>
    </a>
    <a href="https://github.com/sergkeim/php-cloudflare-api/releases">
        <img src="https://img.shields.io/github/release/sergkeim/php-cloudflare-api?style=flat-square" alt="Latest Version"/>
    </a>
</p>

> **Note**: This package is under active development as I expand it to cover Cloudflare API. Consider the public API of this package a little unstable as I work towards a v1.0. [See Coverage](https://sergkeim.github.io/php-cloudflare-api/coverage)

This package provides convenient access to the Cloudflare REST API using PHP.

- [☁️ Cloudflare API v4](https://developers.cloudflare.com/api/)
- [📄 Documentation](https://sergkeim.github.io/php-cloudflare-api/)
- [📓 Coverage](https://sergkeim.github.io/php-cloudflare-api/coverage)
- [📝 Changelog](https://github.com/SergkeiM/php-cloudflare-api/releases)

## Features ✨

* PHP >= 8.2
* Minimal API around the [Guzzle HTTP client](https://github.com/guzzle/guzzle)
* Framework agnostic — Guzzle and the PSR interfaces are the only runtime dependencies
* Light and fast thanks to lazy loading of API classes
* Lazy pagination — iterate every page of a list endpoint without tracking cursors or page counters
* Extensively documented
* Optional Laravel integration (service provider + facade), tested against Laravel 12 and 13

## Quick install 🚀

Via [Composer](https://getcomposer.org).

This command will get you up and running quickly.

```bash
composer require sergkeim/php-cloudflare-api
```

## Running Tests 🧪

If you don't have PHP/Composer installed locally, a Docker setup is provided so you can install dependencies and run the test suite without installing anything on your machine.

A `./dock` helper script wraps the common `docker compose` commands (it starts the container automatically if it isn't already running):

```bash
./dock build           # Build the image (only needed once, or after Dockerfile changes)
./dock install          # composer install
./dock test              # Run the full PHPUnit suite
./dock test --filter=SslTest  # Pass any args straight through to phpunit
./dock cs                 # Check code style (php-cs-fixer, dry run)
./dock analyse            # Run static analysis (phpstan)
./dock coverage           # Run the suite with coverage and check the threshold
./dock fix                # Fix code style (php-cs-fixer)
./dock sh                # Open a shell in the container
./dock down               # Stop and remove the container
./dock matrix              # Run the full PHP x Laravel support matrix locally (mirrors CI)
./dock help               # List all commands
```

### Static analysis

`src` is analysed with [PHPStan](https://phpstan.org) at **level 8**, on the lowest supported PHP version, and CI fails on any error. Run it locally with `./dock analyse` (or `composer analyse`); the configuration lives in `phpstan.neon.dist`.

### Support matrix

This package requires **PHP >= 8.2**.

The Laravel service provider and facade ship in the package but are an *optional* integration. The integration is tested against **Laravel 12 and 13**. `./dock matrix` builds and tests every supported PHP/Laravel combination locally, in isolated containers, mirroring `.github/workflows/tests.yml`:

| PHP | Laravel 12 | Laravel 13 |
| --- | :---: | :---: |
| 8.2 | ✅ | ❌ |
| 8.3 | ✅ | ✅ |
| 8.4 | ✅ | ✅ |
| 8.5 | ✅ | ✅ |

Each matrix cell runs `composer update` and the full test suite inside its own container/vendor volume, so runs never interfere with each other or with your host `composer.json`/`composer.lock`.

Or use `docker compose` directly if you prefer:

```bash
docker compose build
docker compose up -d
docker compose exec php composer install
docker compose exec php composer test
docker compose down
```

The `php` service mounts the repository into the container, so changes you make on your host are picked up immediately without rebuilding.

## Thanks 🙏

* Thanks to [Cloudflare](https://developers.cloudflare.com/api/) for the high quality API and documentation.
* Thanks to [KnpLabs](https://github.com/KnpLabs) for [php-github-api](https://github.com/KnpLabs/php-github-api) used as inspiration for this package.
* Thanks to [Graham Campbell](https://github.com/GrahamCampbell) for [Laravel TestBench](https://github.com/GrahamCampbell/Laravel-TestBench).

## License 📎

`php-cloudflare-api` is licensed under the MIT License - see the [LICENSE](./LICENSE) file for details

---

Cloudflare, the Cloudflare logo, and Cloudflare Workers are trademarks and/or registered trademarks of Cloudflare, Inc. in the United States and other jurisdictions.