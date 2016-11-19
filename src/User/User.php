<?php
namespace AmoCRMAPI\User;

/**
 * @author Artur Sh. Mamedbekov
 */
class User implements UserInterface{
  private $id;
  private $name;
  private $lastName;
  /**
   * @var string
   */
  private $login;
  /**
   * @var string
   */
  private $hash;

  /**
   * @param string $login
   * @param string $hash
   */
  public function __construct($login = null, $hash = null){
    $this->login = $login;
    $this->hash = $hash;
  }

  // Factories
  public static function jsonDecode($json){
    $value = new self;
    if(property_exists($json, 'id')){
      $value->setId((int) $json->id);
    }
    if(property_exists($json, 'name')){
      $value->setName($json->name);
    }
    if(property_exists($json, 'last_name')){
      $value->setLastName($json->last_name);
    }
    if(property_exists($json, 'login')){
      $value->setLogin($json->login);
    }

    return $value;
  }

  // Getters and Setters
  public function setId($id){
    $this->id = $id;
  }
  
  public function getId(){
    return $this->id;
  }

  /**
   * {@inheritdoc}
   */
  public function getLogin(){
    return $this->login;
  }

  public function setLogin($login){
    $this->login = $login;
  }

  /**
   * {@inheritdoc}
   */
  public function getHash(){
    return $this->hash;
  }

  public function setHash($hash){
    $this->hash = $hash;
  }

  public function setName($name){
    $this->name = $name;
  }
  
  public function getName(){
    return $this->name;
  }

  public function setLastName($lastName){
    $this->lastName = $lastName;
  }
  
  public function getLastName(){
    return $this->lastName;
  }
}
