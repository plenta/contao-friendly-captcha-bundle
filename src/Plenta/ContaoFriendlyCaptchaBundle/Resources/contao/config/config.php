<?php

declare(strict_types=1);

/**
 * Plenta Friendly Captcha Bundle for Contao Open Source CMS
 *
 * @copyright     Copyright (c) 2023, Plenta.io
 * @author        Plenta.io <https://plenta.io>
 * @link          https://github.com/plenta/
 */

use Plenta\ContaoFriendlyCaptchaBundle\Classes\Contao\Forms\FormFriendlyCaptcha;

$GLOBALS['TL_FFL']['friendly_captcha'] = FormFriendlyCaptcha::class;
