<?php
namespace AmoCRMAPI\Auth\Proxy;

use AmoCRMAPI\Auth\AuthInterface;
use AmoCRMAPI\User\UserInterface;

/**
 * @author Artur Sh. Mamedbekov
 */
class SessionProxy implements AuthInterface{
  /**
   * @var AuthInterface
   */
  private $auth;
  /**
   * @var string
   */
  private $ssid;

  /**
   * @param AuthInterface $auth
   */
  public function __construct(AuthInterface $auth){
    $this->auth = $auth;
  }

  /**
   * {@inheritdoc}
   */
  public function setUser(UserInterface $user){
    $this->auth->setUser($user);
  }

  /**
   * {@inheritdoc}
   */
  public function getSsid(){
    if(is_null($this->ssid)){
      $this->ssid = $this->auth->getSsid();
    }

    return $this->ssid;
  }
}
