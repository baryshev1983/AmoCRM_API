<?php
namespace AmoCRMAPI\Auth;

use AmoCRMAPI\User\UserInterface;
use AmoCRMAPI\Auth\Exception\UnauthorizedException;
use AmoCRMAPI\ClientInterface;
use AmoCRMAPI\CurlClient;

/**
 * @author Artur Sh. Mamedbekov
 */
class Auth implements AuthInterface{
  const AUTH_URL = '/private/api/auth.php';
  const AUTH_METHOD = 'POST';

  /**
   * @var UserInterface
   */
  private $user;
  /**
   * @var HttpClient
   */
  private $httpClient;

  /**
   * @param UserInterface $user [optional]
   * @param ClientInterface $httpClient
   */
  public function __construct(UserInterface $user, ClientInterface $httpClient){
    $this->setUser($user);
    $this->setHttpClient($httpClient);
  }

  // Implements
  /**
   * {@inheritdoc}
   */
  public function setUser(UserInterface $user){
    $this->user = $user;
  }
  
  /**
   * {@inheritdoc}
   */
  public function getSsid(){
    $client = $this->getHttpClient();
    $response = $client->sendRequest($client->createRequest(self::AUTH_URL.'?type=json', self::AUTH_METHOD, [
      'USER_LOGIN' => $this->user->getLogin(),
      'USER_HASH' => $this->user->getHash(),
    ]));

    if($response->getStatusCode() !== 200){
      throw new UnauthorizedException('', $response->getStatusCode());
    }

    $ssid = '';
    $sessionIdLength = 11;
    foreach($response->getHeader('Set-Cookie') as $header){
      $p = strpos($header, 'session_id');
      if($p === false){
        continue;
      }
      $ssid = substr($header, $p + $sessionIdLength, strpos($header, ';', $p) - $p - $sessionIdLength);
    }

    return $ssid;
  }

  // Setters and Getters
  /**
   * @param HttpClient $client
   */
  public function setHttpClient(ClientInterface $httpClient){
    $this->httpClient = $httpClient;
  }

  /**
   * @return HttpClient
   */
  public function getHttpClient(){
    return $this->httpClient;
  }
}
