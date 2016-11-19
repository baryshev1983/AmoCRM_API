<?php
namespace AmoCMSAPI\User;

use AmoCMSAPI\JsonDecodableInterface;

/**
 * @author Artur Sh. Mamedbekov
 */
interface UserInterface extends JsonDecodableInterface{
  public function getId();

  public function getLogin();

  public function getHash();

  public function getName();

  public function getLastName();
}
