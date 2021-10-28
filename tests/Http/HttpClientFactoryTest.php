<?php


namespace Http;


use Microsoft\Graph\Core\NationalCloud;
use Microsoft\Graph\Exception\GraphClientException;
use Microsoft\Graph\Http\HttpClientFactory;
use Microsoft\Graph\Http\HttpClientInterface;

class HttpClientFactoryTest extends \PHPUnit\Framework\TestCase
{
    function testNationalCloudWithEmptyString() {
        $this->expectException(\InvalidArgumentException::class);
        HttpClientFactory::setNationalCloud("");
    }

    function testNationalCloudWithInvalidUrl() {
        $this->expectException(\InvalidArgumentException::class);
        HttpClientFactory::setNationalCloud("https://www.microsoft.com");
    }

    function testCreateWithNoConfigReturnsDefaultClient() {
        $client = HttpClientFactory::create();
        $this->assertInstanceOf(\GuzzleHttp\Client::class, $client);
    }

    function testCreateWithConfigCreatesClient() {
        $config = [
            "proxy" => "localhost:8000",
            "verify" => false
        ];
        $client = HttpClientFactory::setClientConfig($config)::setNationalCloud(NationalCloud::GERMANY)::create();
        $this->assertInstanceOf(\GuzzleHttp\Client::class, $client);
    }

    function testCreateAdapterReturnsHttpClientInterface() {
        $adapter = HttpClientFactory::setNationalCloud(NationalCloud::US_DOD)::createAdapter();
        $this->assertInstanceOf(HttpClientInterface::class, $adapter);
    }

}