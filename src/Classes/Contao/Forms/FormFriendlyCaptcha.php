<?php

declare(strict_types=1);

/**
 * Plenta Friendly Captcha Bundle for Contao Open Source CMS
 *
 * @copyright     Copyright (c) 2023-2026, Plenta.io
 * @author        Plenta.io <https://plenta.io>
 * @link          https://github.com/plenta/
 */

namespace Plenta\ContaoFriendlyCaptchaBundle\Classes\Contao\Forms;

use Contao\Input;
use Contao\Widget;
use Contao\StringUtil;
use Contao\BackendTemplate;
use Plenta\ContaoFriendlyCaptchaBundle\Enum\FriendlyCaptchaVersion;
use Plenta\ContaoFriendlyCaptchaBundle\Helper\FriendlyCaptcha;

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

        //$this->arrAttributes['maxlength'][] = 'data-theme="'.StringUtil::specialchars($theme).'"';
        //$attributes[] = 'data-theme="'.StringUtil::specialchars($theme).'"';
        // plenta_fc_dark_mode

        $this->friendlyCaptcha = $this->getContainer()->get(FriendlyCaptcha::class);

        $this->friendlyCaptcha
            ->setApiVersion(FriendlyCaptchaVersion::tryFrom($this->plenta_fc_version))
            ->setApiKey($this->plenta_fc_apikey)
            ->setSiteKey($this->plenta_fc_sitekey)
            ->setFriendlyFailure((bool) $this->plenta_fc_friendly_failure)
            ->setEuEndpoint((bool) $this->plenta_fc_eu_endpoint)
        ;

        $this->friendlyCaptcha->generateJs();
    }

    public function validate(): void
    {
        $translator = $this->getContainer()->get('translator');
        $logger = $this->getContainer()->get('monolog.logger.contao.error');

        $version = FriendlyCaptchaVersion::tryFrom($this->plenta_fc_version) ?? FriendlyCaptchaVersion::V1;

        if ($version === FriendlyCaptchaVersion::V2) {
            $fieldName = 'frc-captcha-response';
        } else {
            $fieldName = empty($this->plenta_fc_hf_name) ? 'frc-captcha-solution' : $this->plenta_fc_hf_name;
        }

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

    public function parse($arrAttributes = null): string
    {
        $request = $this->getContainer()->get('request_stack')->getCurrentRequest();

        if ($request && $this->getContainer()->get('contao.routing.scope_matcher')->isBackendRequest($request))
        {
            $template = new BackendTemplate('be_wildcard');
            $template->title = $GLOBALS['TL_LANG']['FFL']['friendly_captcha'][0];

            return $template->parse();
        }

        return parent::parse($arrAttributes);
    }
}
