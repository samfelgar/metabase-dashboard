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
        $metabaseSecretKey = $this->dashboard->getKey();

        $configuration = Configuration::forSymmetricSigner(
            new Sha256(),
            InMemory::base64Encoded($metabaseSecretKey)
        );

        $token = $configuration->builder()
            ->withClaim('resource', $this->dashboard->getResource())
            ->withClaim('params', $this->dashboard->getParams())
            ->getToken($configuration->signer(), $configuration->signingKey());

        return "{$metabaseSiteUrl}/embed/dashboard/{$token->toString()}#bordered=true&titled=false";
    }

}