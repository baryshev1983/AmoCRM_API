<?php
namespace AmoCMSAPITest\Auth\Proxy;

use AmoCMSAPI\CurlClient;
use AmoCMSAPI\User\UserInterface;
use AmoCMSAPI\User\User;
use AmoCMSAPI\Auth\AuthInterface;
use AmoCMSAPI\Auth\Auth;
use AmoCMSAPI\Auth\Proxy\SessionProxy;

/**
 * @author Artur Sh. Mamedbekov
 */
class SessionProxyTest extends \PHPUnit_Framework_TestCase{
  const DEFAULT_SUBDOMAIN = 'test';

  // Factories
  public function createClient($subdomain = null){
    return new CurlClient(is_null($subdomain)? self::DEFAULT_SUBDOMAIN : $subdomain);
  }

  public function createAuthMock(UserInterface $user, $subdomain = null){
    return $this->createMock(Auth::class, ['getSsid'], [$user, $this->createClient($subdomain)]);
  }

  public function createProxy(AuthInterface $auth){
    return new SessionProxy($auth);
  }

  // Tests
  public function testGetSsid(){
    $ssid = 'ssid';
    $auth = $this->createAuthMock(new User('test', '123'), 'test');
    $proxy = $this->createProxy($auth);

    $auth->expects($this->once())
      ->method('getSsid')
      ->will($this->returnValue($ssid));

    $this->assertEquals($ssid, $proxy->getSsid());
    $this->assertEquals($ssid, $proxy->getSsid());
  }
}
