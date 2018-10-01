<?php
namespace AmoCRMAPI\Auth;

use AmoCRMAPI\User\UserInterface;
use AmoCRMAPI\Auth\Exception\UnauthorizedException;

/**
 * @author Artur Sh. Mamedbekov
 */
interface AuthInterface{
  /**
   * @param User $user
   */
  public function setUser(UserInterface $user);

  /**
   * @return UserInterface
   */
  public function getUser();

  /**
   * @throws UnauthorizedException Выбрасывается в случае ошибки при попытке 
   * авторизации.
   *
   * @return string SSID
   */
  public function getSsid();
}
