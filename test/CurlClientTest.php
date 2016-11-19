<?php
namespace AmoCMSAPITest;

use Psr\Http\Message\UriInterface;
use Psr\Http\Message\RequestInterface;
use Zend\Diactoros\Request;
use AmoCMSAPI\CurlClient;

/**
 * @author Artur Sh. Mamedbekov
 */
class CurlClientTest extends \PHPUnit_Framework_TestCase{
  const DEFAULT_SUBDOMAIN = 'test';

  // Factories
  public function createClient($subdomain = null){
    return new CurlClient(is_null($subdomain)? self::DEFAULT_SUBDOMAIN : $subdomain);
  }

  // Tests
  public function testCreateUri(){
    $method = '/private/api/auth.php';
    $client = $this->createClient();

    $uri = $client->createUri($method);

    $this->assertInstanceof(UriInterface::class, $uri);
    $this->assertEquals('https://' . self::DEFAULT_SUBDOMAIN . '.' . CurlClient::DOMAIN . $method, (string) $uri);
  }

  public function testCreateRequest(){
    $targetMethodUrl = '/private/api/auth.php';
    $method = 'POST';
    $data = [
      'USER_LOGIN' => 'test@mail.com',
      'USER_HASH' => '123',
    ];
    $client = $this->createClient();

    $request = $client->createRequest($targetMethodUrl, $method, $data);

    $this->assertInstanceof(RequestInterface::class, $request);
    $this->assertEquals('https://' . self::DEFAULT_SUBDOMAIN . '.' . CurlClient::DOMAIN . $targetMethodUrl, (string) $request->getUri());
    $this->assertEquals($method, $request->getMethod());
    $this->assertEquals(json_encode($data), (string) $request->getBody());
  }
}
