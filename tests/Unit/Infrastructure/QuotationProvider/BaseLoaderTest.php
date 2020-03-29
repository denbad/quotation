<?php

declare(strict_types=1);

namespace App\Tests\Unit\Infrastructure\QuotationProvider;

use App\Infrastructure\QuotationProvider\Loader;
use GuzzleHttp\ClientInterface;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamInterface;

abstract class BaseLoaderTest extends TestCase
{
    public function testLoad(): void
    {
        $stream = $this->getMockBuilder(StreamInterface::class)->getMock();

        $stream
            ->expects($this->any())
            ->method('getContents')
            ->willReturn($this->contents())
        ;

        $response = $this->getMockBuilder(ResponseInterface::class)->getMock();

        $response
            ->expects($this->any())
            ->method('getBody')
            ->willReturn($stream)
        ;

        $client = $this->getMockBuilder(ClientInterface::class)->getMock();

        $client
            ->expects($this->any())
            ->method('request')
            ->with(...$this->requestArguments())
            ->willReturn($response)
        ;

        /** @var ClientInterface $client */
        $client = $client;

        $quotations = $this->loader($client)->load();

        $this->assertEquals($quotations[1], $this->expected());
    }

    abstract protected function requestArguments(): array;

    abstract protected function loader(ClientInterface $client): Loader;

    abstract protected function contents(): string;

    abstract protected function expected(): array;
}
