<?php
namespace AmoCMSAPI\Tag;

class Tag implements TagInterface{
  /**
   * @var int
   */
  private $id;
  /**
   * @var string
   */
  private $name;

  public function __construct($name = null){
    $this->setName($name);
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

    return $value;
  }

  // Getters and Setters
  public function getId(){
    return $this->id;
  }

  public function setId($id){
    $this->id = $id;
  }

  public function getName(){
    return $this->name;
  }

  public function setName($name){
    $this->name = $name;
  }
}
