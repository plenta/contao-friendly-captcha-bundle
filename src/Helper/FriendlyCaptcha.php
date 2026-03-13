<?php

declare(strict_types=1);

/**
 * Plenta Friendly Captcha Bundle for Contao Open Source CMS
 *
 * @copyright     Copyright (c) 2023-2026, Plenta.io
 * @author        Plenta.io <https://plenta.io>
 * @link          https://github.com/plenta/
 */

namespace Plenta\ContaoFriendlyCaptchaBundle\Helper;

use AllowDynamicProperties;
use Symfony\Component\Asset\Packages;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Component\HttpClient\Exception\ClientException;
use Plenta\ContaoFriendlyCaptchaBundle\Enum\FriendlyCaptchaVersion;

#[AllowDynamicProperties]
class FriendlyCaptcha
{
    protected array $errors = [];

    protected string $apiKey;

    protected string $siteKey;

    protected bool $friendlyFailure;

    protected bool $euEndpoint;

    protected FriendlyCaptchaVersion $apiVersion = FriendlyCaptchaVersion::V2;

    public function __construct(protected HttpClientInterface $httpClient, protected Packages $asset)
    {
    }

    public function getApiKey(): string
    {
        return $this->apiKey;
    }

    public function setApiKey(string $apiKey): self
    {
        $this->apiKey = $apiKey;

        return $this;
    }

    public function getSiteKey(): string
    {
        return $this->siteKey;
    }

    public function setSiteKey(string $siteKey): self
    {
        $this->siteKey = $siteKey;

        return $this;
    }

    public function isFriendlyFailure(): bool
    {
        return $this->friendlyFailure;
    }

    public function setFriendlyFailure(bool $friendlyFailure): self
    {
        $this->friendlyFailure = $friendlyFailure;

        return $this;
    }

    public function isEuEndpoint(): bool
    {
        return $this->euEndpoint;
    }

    public function setEuEndpoint(bool $euEndpoint): self
    {
        $this->euEndpoint = $euEndpoint;

        return $this;
    }

    public function setApiVersion(FriendlyCaptchaVersion $version): self
    {
        $this->apiVersion = $version;

        return $this;
    }

    public function getApiVersion(): FriendlyCaptchaVersion
    {
        return $this->apiVersion;
    }

    public function verifySolution($solution): bool
    {
        try {
            if ($this->apiVersion === FriendlyCaptchaVersion::V2) {
                $options = [
                    'headers' => [
                        'X-API-Key' => $this->getApiKey(),
                    ],
                    'json' => [
                        'response' => $solution,
                        'sitekey' => $this->getSiteKey(),
                    ],
                ];

            } else {
                $options = [
                    'body' => [
                        'solution' => $solution,
                        'secret' => $this->getApiKey(),
                        'sitekey' => $this->getSiteKey(),
                    ],
                ];
            }

            $response = $this->httpClient->request(
                'POST',
                $this->getVerifyEndpoint(),
                $options
            );

            $data = json_decode($response->getContent(), true);

            if (!($data['success'] ?? false)) {
                $this->errors = $data['errors'] ?? [];
            }

            return (bool) ($data['success'] ?? false);

        } catch (ClientException $e) {
            $data = json_decode($e->getResponse()->getContent(false), true);
            $this->errors = $data['errors'] ?? [];

            return $this->isFriendlyFailure();
        }
    }

    public function getErrors(): array
    {
        return $this->errors;
    }

    public function generateJs(): void
    {
        if (false === isset($GLOBALS['TL_BODY']['friendlyCaptchaJs'])) {
            $url = $this->asset->getUrl('plentafriendlycaptcha/friendlyCaptcha.js', 'plentafriendlycaptcha');
            $GLOBALS['TL_BODY']['friendlyCaptchaJs'] = '<script src="/'.ltrim($url, '/').'" defer></script>';
        }
    }

    private function getVerifyEndpoint(): string
    {
        if ($this->apiVersion === FriendlyCaptchaVersion::V1) {
            return $this->isEuEndpoint()
                ? 'https://eu-api.friendlycaptcha.eu/api/v1/siteverify'
                : 'https://api.friendlycaptcha.com/api/v1/siteverify';
        }

        return $this->isEuEndpoint()
            ? 'https://eu.frcapi.com/api/v2/captcha/siteverify'
            : 'https://global.frcapi.com/api/v2/captcha/siteverify';
    }
}
