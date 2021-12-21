<?php

namespace Samfelgar\MetabaseDashboard\Services;

use Lcobucci\JWT\Configuration;
use Lcobucci\JWT\Signer\Hmac\Sha256;
use Lcobucci\JWT\Signer\Key\InMemory;
use Samfelgar\MetabaseDashboard\DataTransferObjects\Dashboard;

class Iframe
{
    private Dashboard $dashboard;

    public function __construct(Dashboard $dashboard)
    {
        $this->dashboard = $dashboard;
    }

    public function getUrl(): string
    {
        $metabaseSiteUrl = $this->dashboard->getUrl();

        $token = $this->getToken();

        return "{$metabaseSiteUrl}/embed/dashboard/{$token}#bordered=true&titled=false";
    }

    private function getJWTConfiguration(): Configuration
    {
        return Configuration::forSymmetricSigner(
            new Sha256(),
            InMemory::plainText($this->dashboard->getKey())
        );
    }

    private function getToken(): string
    {
        $configuration = $this->getJWTConfiguration();

        $referenceDate = now();
        $expiresAt = $referenceDate->addMinutes(60);

        return $configuration->builder()
            ->withClaim('resource', [
                'dashboard' => $this->dashboard->getResource()
            ])
            ->withClaim('params', $this->dashboard->getParams())
            ->issuedAt($referenceDate->toDateTimeImmutable())
            ->expiresAt($expiresAt->toDateTimeImmutable())
            ->getToken($configuration->signer(), $configuration->signingKey())
            ->toString();
    }

}