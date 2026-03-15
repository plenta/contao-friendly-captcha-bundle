# Contao Friendly Captcha Bundle

![Contao](https://img.shields.io/badge/Contao-5.x-orange) ![Friendly Captcha v1 + v2 supported](https://img.shields.io/badge/FriendlyCaptcha-v1%20%7C%20v2-green)

Integrates **Friendly Captcha** into Contao forms to protect them from spam and automated submissions.

This bundle supports **Friendly Captcha v1 and v2** and allows selecting the desired version directly in the form field configuration.

Friendly Captcha is a privacy-friendly CAPTCHA alternative that works without user tracking or behavioral analysis.

**This bundle is open source and free. 🚀**

https://friendlycaptcha.com

![Friendly Captcha](docs/friendlycaptcha.png)

## Installation

### Install using Contao Manager

Search for **captcha** or **friendly** and you will find this extension.

### Install using Composer

```bash
composer require plenta/contao-friendly-captcha-bundle
```

## Features

- Easy integration into Contao forms
- Support for **Friendly Captcha v1 and v2**
- Version selection directly in the form field settings
- Optional EU endpoints
- Configurable widget theme (light, dark, auto)
- Configurable puzzle start behaviour
- Privacy-friendly CAPTCHA without tracking

## Configuration

To use Friendly Captcha you need:

- a **Site Key**
- an **API Key**

You can create both keys in the Friendly Captcha dashboard:

https://friendlycaptcha.com

## Friendly Captcha Versions

This bundle supports both Friendly Captcha versions:

| Version | Description |
|--------|-------------|
| v1 | Legacy widget |
| v2 | New SDK-based widget with improved configuration |

The version can be selected directly in the form field settings.

## System requirements

- PHP: `^8.1`
- Contao: `^5.3 || ^5.7` (and later)
