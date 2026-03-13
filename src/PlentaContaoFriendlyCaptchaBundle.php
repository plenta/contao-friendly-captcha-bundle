<?php

declare(strict_types=1);

/**
 * Plenta Friendly Captcha Bundle for Contao Open Source CMS
 *
 * @copyright     Copyright (c) 2023-2026, Plenta.io
 * @author        Plenta.io <https://plenta.io>
 * @link          https://github.com/plenta/
 */

namespace Plenta\ContaoFriendlyCaptchaBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class PlentaContaoFriendlyCaptchaBundle extends Bundle
{
    #[\Override]
    public function getPath(): string
    {
        return \dirname(__DIR__);
    }
}
