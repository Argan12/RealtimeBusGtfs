<?php

namespace App\Service;

interface PbFileServiceInterface
{
    /**
     * Get protobuf file from Astuce server
     * @param string $url
     * @return bool|string
     */
    public function getFile(string $url): bool|string;
}