<?php
namespace AmoCMSAPI;

use Http\Client\HttpClient;

interface ClientInterface extends HttpClient{
  public function setSubdomain($subdomain);

  public function createUri($targetMethodUrl);

  /**
   * @param string $targetMethodUrl
   * @param string $method
   * @param array|\JsonSerializable $data
   */
  public function createRequest($targetMethodUrl, $method, $data = []);
}
