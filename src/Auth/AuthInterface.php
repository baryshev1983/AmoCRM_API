<?php
namespace AmoCMSAPI\Auth;

use AmoCMSAPI\User\UserInterface;
use AmoCMSAPI\Auth\Exception\UnauthorizedException;

/**
 * @author Artur Sh. Mamedbekov
 */
interface AuthInterface{
  /**
   * @param User $user
   */
  public function setUser(UserInterface $user);

  /**
   * @throws UnauthorizedException Выбрасывается в случае ошибки при попытке 
   * авторизации.
   *
   * @return string SSID
   */
  public function getSsid();
}
