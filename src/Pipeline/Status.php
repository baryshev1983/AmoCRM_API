<?php
namespace AmoCRMAPI\Pipeline;

/**
 * @author Artur Sh. Mamedbekov
 */
class Status implements StatusInterface{
  /**
   * @var int
   */
  private $id;

  /**
   * @var string
   */
  private $name;

  /**
   * @var string
   */
  private $color;

  /**
   * @var int
   */
  private $sort;

  /**
   * @var bool
   */
  private $isEditable;

  /**
   * {@inheritdoc}
   */
  public static function jsonDecode($json){
    $value = new self;
    if(property_exists($json, 'id')){
      $value->setId((int) $json->id);
    }
    if(property_exists($json, 'name')){
      $value->setName($json->name);
    }
    if(property_exists($json, 'color')){
      $value->setColor($json->color);
    }
    if(property_exists($json, 'sort')){
      $value->setSort((int) $json->sort);
    }
    if(property_exists($json, 'editable')){
      $value->isEditable = $json->editable == 'Y';
    }

    return $value;
  }

  /**
   * {@inheritdoc}
   */
  public function jsonSerialize(){
    $json = [];
    if(!is_null($this->getId())){
      $json['id'] = $this->getId();
    }
    if(!is_null($this->getName())){
      $json['name'] = $this->getName();
    }
    if(!is_null($this->getColor())){
      $json['color'] = $this->getColor();
    }
    if(!is_null($this->getSort())){
      $json['sort'] = $this->getSort();
    }

    return $json;
  }

  /**
   * @param int $id
   */
  public function setId($id){
    $this->id = $id;
  }
  
  /**
   * {@inheritdoc}
   */
  public function getId(){
    return $this->id;
  }

  /**
   * @param string $name
   */
  public function setName($name){
    $this->name = $name;
  }
  
  /**
   * {@inheritdoc}
   */
  public function getName(){
    return $this->name;
  }

  /**
   * @param string $color
   */
  public function setColor($color){
    $this->color = $color;
  }
  
  /**
   * {@inheritdoc}
   */
  public function getColor(){
    return $this->color;
  }

  /**
   * @param int $sort
   */
  public function setSort($sort){
    $this->sort = $sort;
  }
  
  /**
   * {@inheritdoc}
   */
  public function getSort(){
    return $this->sort;
  }

  /**
   * {@inheritdoc}
   */
  public function isEditable(){
    return $this->isEditable;
  }
}
