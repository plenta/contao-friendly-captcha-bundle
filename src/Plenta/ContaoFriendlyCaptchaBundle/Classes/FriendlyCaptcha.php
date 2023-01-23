<?php

declare(strict_types=1);

/**
 * Plenta Friendly Captcha Bundle for Contao Open Source CMS
 *
 * @copyright     Copyright (c) 2023, Plenta.io
 * @author        Plenta.io <https://plenta.io>
 * @link          https://github.com/plenta/
 */

namespace Plenta\ContaoFriendlyCaptchaBundle\Classes;

use Psr\Log\LoggerInterface;
use Symfony\Component\Asset\Packages;
use Symfony\Component\HttpClient\Exception\ClientException;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class FriendlyCaptcha
{
    protected array $errors = [];
    protected string $apiKey;
    protected string $siteKey;
    protected bool $friendlyFailure;
    protected bool $euEndpoint;

    public function __construct(protected HttpClientInterface $httpClient, protected Packages $asset)
    {
    }

    /**
     * @return string
     */
    public function getApiKey(): string
    {
        return $this->apiKey;
    }

    /**
     * @param string $apiKey
     *
     * @return FriendlyCaptcha
     */
    public function setApiKey(string $apiKey): self
    {
        $this->apiKey = $apiKey;

        return $this;
    }

    /**
     * @return string
     */
    public function getSiteKey(): string
    {
        return $this->siteKey;
    }

    /**
     * @param string $siteKey
     *
     * @return FriendlyCaptcha
     */
    public function setSiteKey(string $siteKey): self
    {
        $this->siteKey = $siteKey;

        return $this;
    }

    /**
     * @return bool
     */
    public function isFriendlyFailure(): bool
    {
        return $this->friendlyFailure;
    }

    /**
     * @param bool $friendlyFailure
     *
     * @return FriendlyCaptcha
     */
    public function setFriendlyFailure(bool $friendlyFailure): self
    {
        $this->friendlyFailure = $friendlyFailure;

        return $this;
    }

    /**
     * @return bool
     */
    public function isEuEndpoint(): bool
    {
        return $this->euEndpoint;
    }

    /**
     * @param bool $euEndpoint
     *
     * @return FriendlyCaptcha
     */
    public function setEuEndpoint(bool $euEndpoint): self
    {
        $this->euEndpoint = $euEndpoint;

        return $this;
    }

    public function verifySolution($solution): bool
    {
        try {
            $response = $this->httpClient->request('POST', $this->isEuEndpoint() ? 'https://eu-api.friendlycaptcha.eu/api/v1/siteverify' : 'https://api.friendlycaptcha.com/api/v1/siteverify', [
                'body' => [
                    'solution' => $solution,
                    'secret' => $this->getApiKey(),
                    'sitekey' => $this->getSiteKey(),
                ],
            ]);
            $data = json_decode($response->getContent(), true);
            if (!$data['success']) {
                $this->errors = $data['errors'];
            }

            return (bool) ($data['success'] ?? false);
        } catch (ClientException $e) {
            $data = json_decode($e->getResponse()->getContent(false), true);
            $this->errors = $data['errors'];

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
}
