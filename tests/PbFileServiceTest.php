<?php

namespace App\Tests;

use App\Service\PbFileServiceInterface;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

class PbFileServiceTest extends TestCase
{
    private string $pbFilePath;
    private PbFileServiceInterface $service;

    /**
     * Set up test
     * @return void
     */
    protected function setUp(): void
    {
        $this->pbFilePath = $_ENV['GTFS_FILE_PATH'];
        $this->service = $this->getMockBuilder(PbFileServiceInterface::class)
            ->getMock();
    }

    /**
     * Test get protobuf file
     * @return void
     */
    #[Test]
    public function testGetPbFile()
    {
        $pbFileMockedContent = "fake_protobuf_content";

        $this->service
            ->method('getFile')
            ->with($this->pbFilePath)
            ->willReturn($pbFileMockedContent);

        $result = $this->service->getFile($this->pbFilePath);
        $this->assertNotEmpty($result);
    }
}
