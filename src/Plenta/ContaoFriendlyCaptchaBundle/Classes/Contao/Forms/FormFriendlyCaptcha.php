<?php

declare(strict_types=1);

/**
 * Plenta Friendly Captcha Bundle for Contao Open Source CMS
 *
 * @copyright     Copyright (c) 2023, Plenta.io
 * @author        Plenta.io <https://plenta.io>
 * @link          https://github.com/plenta/
 */

namespace Plenta\ContaoFriendlyCaptchaBundle\Classes\Contao\Forms;

use Contao\Input;
use Contao\StringUtil;
use Contao\System;
use Contao\Widget;
use Plenta\ContaoFriendlyCaptchaBundle\Classes\FriendlyCaptcha;

class FormFriendlyCaptcha extends Widget
{
    protected $strTemplate = 'form_friendly_captcha';

    protected $strCaptchaKey;

    protected FriendlyCaptcha $friendlyCaptcha;

    protected $strPrefix = 'widget widget-captcha widget-friendly-captcha mandatory';

    public function __construct($arrAttributes = null)
    {
        parent::__construct($arrAttributes);

        $this->arrAttributes['maxlength'] = 32;
        $this->strCaptchaKey = 'friendly_captcha_'.$this->strId;
        $this->arrAttributes['required'] = true;
        $this->arrConfiguration['mandatory'] = true;
        $this->fc_apikey = $this->plenta_fc_sitekey;
        $this->friendlyCaptcha = System::getContainer()->get(FriendlyCaptcha::class);
        $this->friendlyCaptcha
            ->setApiKey($this->plenta_fc_apikey)
            ->setSiteKey($this->plenta_fc_sitekey)
            ->setFriendlyFailure((bool) $this->plenta_fc_friendly_failure)
            ->setEuEndpoint((bool) $this->plenta_fc_eu_endpoint)
        ;
        $this->friendlyCaptcha->generateJs();
    }

    public function __set($strKey, $varValue): void
    {
        parent::__set($strKey, $varValue);
    }

    public function __get($strKey)
    {
        return parent::__get($strKey);
    }

    public function validate(): void
    {
        $container = System::getContainer();
        $translator = $container->get('translator');
        $logger = System::getContainer()->get('monolog.logger.contao.error');
        $fieldName = empty($this->plenta_fc_hf_name) ? 'frc-captcha-solution' : $this->plenta_fc_hf_name;
        if (!$this->friendlyCaptcha->verifySolution(StringUtil::decodeEntities(Input::post($fieldName)))) {
            $this->class = 'error';
            $this->addError($translator->trans('ERR.plenta_fc_error', [], 'contao_default'));
        }
        if (!empty($this->friendlyCaptcha->getErrors())) {
            $logger->error('There has been an error while verifying the friendly captcha: '.implode(', ', $this->friendlyCaptcha->getErrors()));
        }
    }

    public function generate(): void
    {
    }
}
