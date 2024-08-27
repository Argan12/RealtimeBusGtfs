<?php

namespace App\Service;

use RuntimeException;

/**
 * PbFileService
 * Read .pb file (protobuf file)
 */
class PbFileService implements PbFileServiceInterface
{
    /**
     * Get protobuf file from Astuce server
     * @param string $url
     * @return bool|string
     */
    public function getFile(string $url): bool|string
    {
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $fileContent = curl_exec($ch);

        if (curl_errno($ch)) {
            throw new RuntimeException("Error");
        }

        curl_close($ch);
        return $fileContent;
    }
}