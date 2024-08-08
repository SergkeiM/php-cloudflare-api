# ☁️ PHP CloudFlare API

![Build Status](https://github.com/SergkeiM/php-cloudflare-api/actions/workflows/ci.yml/badge.svg)
[![StyleCI](https://styleci.io/repos/839240046/shield?style=flat)](https://styleci.io/repos/839240046)
[![Latest Stable Version](https://poser.pugx.org/sergkeim/php-cloudflare-api/v/stable)](https://packagist.org/packages/sergkeim/php-cloudflare-api)
[![Total Downloads](https://poser.pugx.org/sergkeim/php-cloudflare-api/downloads)](https://packagist.org/packages/sergkeim/php-cloudflare-api)
[![Monthly Downloads](https://poser.pugx.org/sergkeim/php-cloudflare-api/d/monthly)](https://packagist.org/packages/sergkeim/php-cloudflare-api)
[![Daily Downloads](https://poser.pugx.org/sergkeim/php-cloudflare-api/d/daily)](https://packagist.org/packages/sergkeim/php-cloudflare-api)

A simple Object Oriented wrapper for CloudFlare API, written with PHP.

Uses [CloudFlare API v4](https://developers.cloudflare.com/api/).

## 💡 Requirements

* PHP >= 7.2
* A [PSR-17 implementation](https://packagist.org/providers/psr/http-factory-implementation)
* A [PSR-18 implementation](https://packagist.org/providers/psr/http-client-implementation)

## 🚀 Quick install

Via [Composer](https://getcomposer.org).

This command will get you up and running quickly with a [Guzzle](https://github.com/guzzle/guzzle), PHP HTTP client.

```bash
composer require sergkeim/php-cloudflare-api guzzlehttp/guzzle
```

## ⚙️ Framework integrations

### Laravel

Coming Soon

## 📋 TODO List

### Accounts

- [x] List Accounts
- [x] Account Details
- [x] Update Account

#### Account Members

- [ ] List Members
- [ ] Add Member
- [ ] Remove Member
- [ ] Member Details
- [ ] Update Member

## 🙏 Thanks

Thanks to [KnpLabs](https://github.com/KnpLabs) for [php-github-api](https://github.com/KnpLabs/php-github-api) used as inspiration for this package.