<?php
namespace AmoCMSAPI\CustomField;

class CustomField implements CustomFieldInterface{
  /**
   * @var int
   */
  private $id;
  /**
   * @var int
   */
  private $requestId;
  /**
   * @var string
   */
  private $name;
  /**
   * @see CustomFieldType
   *
   * @var int
   */
  private $type;
  /**
   * @see ElementType
   *
   * @var int
   */
  private $elementType;
  /**
   * @var string
   */
  private $origin;
  /**
   * @var bool
   */
  private $disabled;
  /**
   * @var ValueInterface[]
   */
  private $values;

  public function __construct(){
    $this->setValues([]);
  }

  // Factories
  /**
   * {@inheritdoc}
   */
  public static function jsonDecode($json){
    $value = new static;
    if(property_exists($json, 'id')){
      $value->setId((int) $json->id);
    }
    if(property_exists($json, 'request_id')){
      $value->setRequestId((int) $json->request_id);
    }
    if(property_exists($json, 'name')){
      $value->setName($json->name);
    }
    if(property_exists($json, 'type')){
      $value->setType((int) $json->type);
    }
    if(property_exists($json, 'type_id')){
      $value->setType((int) $json->type_id);
    }
    if(property_exists($json, 'element_type')){
      $value->setElementType((int) $json->element_type);
    }
    if(property_exists($json, 'origin')){
      $value->setOrigin($json->origin);
    }
    if(property_exists($json, 'disabled')){
      $value->setDisabled((bool) $json->disabled);
    }
    if(property_exists($json, 'values')){
      $value->setValues(array_map(function($json){
        return Value::jsonDecode($json);
      }, $json->values));
    }

    return $value;
  }

  // Getters and Setters
  /**
   * {@inheritdoc}
   */
  public function getId(){
    return $this->id;
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
  public function getRequestId(){
    return $this->requestId;
  }

  /**
   * @param int $requestId
   */
  public function setRequestId($requestId){
    $this->requestId = $requestId;
  }

  /**
   * {@inheritdoc}
   */
  public function getName(){
    return $this->name;
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
  public function getType(){
    return $this->type;
  }

  /**
   * @param int $type
   */
  public function setType($type){
    $this->type = $type;
  }

  /**
   * {@inheritdoc}
   */
  public function getElementType(){
    return $this->elementType;
  }

  /**
   * @param int $elementType
   */
  public function setElementType($elementType){
    $this->elementType = $elementType;
  }

  /**
   * @param string $origin
   */
  public function setOrigin($origin){
    $this->origin = $origin;
  }

  /**
   * {@inheritdoc}
   */
  public function getOrigin(){
    return $this->origin;
  }

  /**
   * {@inheritdoc}
   */
  public function isDisabled(){
    return $this->disabled;
  }

  /**
   * @param bool $disabled
   */
  public function setDisabled($disabled){
    $this->disabled = $disabled;
  }

  /**
   * {@inheritdoc}
   */
  public function getValues(){
    return $this->values;
  }

  /**
   * @param ValueInterface[] $values
   */
  public function setValues(array $values){
    $this->values = $values;
  }

  // Other
  /**
   * {@inheritdoc}
   */
  public function jsonSerialize(){
    $json = [];
    if(!is_null($this->getId())){
      $json['id'] = $this->getId();
    }
    if(!is_null($this->getRequestId())){
      $json['request_id'] = $this->getRequestId();
    }
    if(!is_null($this->getName())){
      $json['name'] = $this->getName();
    }
    if(!is_null($this->getType())){
      $json['type'] = $this->getType();
    }
    if(!is_null($this->getElementType())){
      $json['element_type'] = $this->getElementType();
    }
    if(!is_null($this->getOrigin())){
      $json['origin'] = $this->getOrigin();
    }
    if(!is_null($this->disabled)){
      $json['disabled'] = (int) $this->isDisabled();
    }
    if(count($this->getValues())){
      $json['values'] = $this->getValues();
    }

    return $json;
  }
}
