<?php

declare(strict_types=1);

namespace App\Tests\Integration\Symfony\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

final class ConversionControllerTest extends WebTestCase
{
    public function testWithMissingNominal(): void
    {
        $response = static::getResponse('/convert/eurusd/');
        $content = json_decode($response->getContent(), true, 512, JSON_THROW_ON_ERROR);

        $this->assertEquals(400, $response->getStatusCode());
        $this->assertEquals($content, ['400' => ['nominal' => 'This value should not be blank']]);
    }

    public function testWithMalformedNominal(): void
    {
        $response = static::getResponse('/convert/eurusd/?nominal=aaa');
        $content = json_decode($response->getContent(), true, 512, JSON_THROW_ON_ERROR);

        $this->assertEquals(400, $response->getStatusCode());
        $this->assertEquals($content, ['400' => ['nominal' => 'Float value expected']]);
    }

    public function testWhenNotSupported(): void
    {
        $response = static::getResponse('/convert/xxxzzz/?nominal=10');
        $content = json_decode($response->getContent(), true, 512, JSON_THROW_ON_ERROR);

        $this->assertEquals(404, $response->getStatusCode());
        $this->assertEquals($content, ['404' => 'Currency code not supported']);
    }

    public function test10EurToRub(): void
    {
        $response = static::getResponse('/convert/eurrub/?nominal=10');
        $content = json_decode($response->getContent(), true, 512, JSON_THROW_ON_ERROR);

        $this->assertEquals(200, $response->getStatusCode());

        $data = $content['200'];
        $this->assertEquals($data['code'], 'EURRUB');
        $this->assertEquals($data['nominal'], '10');
        $this->assertTrue(isset($data['bid']) && $data['bid']);
        $this->assertTrue(isset($data['effectiveFrom']) && $data['effectiveFrom']);
    }

    public function test100RubToEur(): void
    {
        $response = static::getResponse('/convert/rubeur/?nominal=100');
        $content = json_decode($response->getContent(), true, 512, JSON_THROW_ON_ERROR);

        $this->assertEquals(200, $response->getStatusCode());

        $data = $content['200'];
        $this->assertEquals($data['code'], 'RUBEUR');
        $this->assertEquals($data['nominal'], '100');
        $this->assertTrue(isset($data['bid']) && $data['bid']);
        $this->assertTrue(isset($data['effectiveFrom']) && $data['effectiveFrom']);
    }

    public function testRubToGbp(): void
    {
        $response = static::getResponse('/convert/rubgbp/?nominal=200');
        $content = json_decode($response->getContent(), true, 512, JSON_THROW_ON_ERROR);

        $this->assertEquals(200, $response->getStatusCode());

        $data = $content['200'];
        $this->assertEquals($data['code'], 'RUBGBP');
        $this->assertEquals($data['nominal'], '200');
        $this->assertTrue(isset($data['bid']) && $data['bid']);
        $this->assertTrue(isset($data['effectiveFrom']) && $data['effectiveFrom']);
    }

    private static function getResponse(string $url): Response
    {
        $client = static::createClient();
        $client->request('GET', $url);

        return $client->getResponse();
    }
}
