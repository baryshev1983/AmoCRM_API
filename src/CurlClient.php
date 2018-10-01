<?php
namespace AmoCRMAPI;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\UriInterface;
use Http\Client\HttpClient;
use Http\Client\Curl\Client;
use Zend\Diactoros\Uri;
use Zend\Diactoros\Request;
use Zend\Diactoros\Stream;

/**
 * @author Artur Sh. Mamedbekov
 */
class CurlClient implements ClientInterface{
  const DOMAIN = 'amocrm.ru';

  private $subdomain;
  private $client;

  public function __construct($subdomain, Client $client = null){
    $this->subdomain = $subdomain;
    $this->client = $client;
  }

  // Setters and Getters
  protected function getClient(){
    if(!$this->client instanceof Client){
      $this->client = new Client;
    }

    return $this->client;
  }

  public function setSubdomain($subdomain){
    $this->subdomain = $subdomain;
  }

  public function getSubdomain(){
    return $this->subdomain;
  }

  // Factories
  /**
   * @return UriInterface
   */
  public function createUri($targetMethodUrl){
    $uriString = sprintf('https://%s.%s%s', $this->subdomain, self::DOMAIN, $targetMethodUrl);

    return new Uri($uriString);
  }

  /**
   * @return RequestInterface
   */
  public function createRequest($targetMethodUrl, $method, $data = []){
    $body = new Stream('php://temp', 'w+');
    if($method == 'POST'){
      $body->write(json_encode($data));
    }
    else{
      $targetMethodUrl .= '?' . http_build_query($data);
    }

    return new Request($this->createUri($targetMethodUrl), $method, $body, [
      'Content-Type' => 'application/json'
    ]);
  }

  // Other
  /**
   * {@inheritdoc}
   */
  public function sendRequest(RequestInterface $request){
    return $this->getClient()->sendRequest($request);
  }
}
