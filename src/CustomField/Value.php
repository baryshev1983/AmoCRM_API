<?php
namespace AmoCRMAPI\CustomField;

class Value implements ValueInterface{
  /**
   * @var int
   */
  private $id;
  /**
   * @var string
   */
  private $value;
  /**
   * @var string
   */
  private $enum;
  /**
   * @var \DateTime
   */
  private $updated;

  public function __construct($value = null, $enum = null){
    $this->setValue($value);
    $this->setEnum($enum);
    $this->setUpdated(new \DateTime);
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
    if(property_exists($json, 'value')){
      $value->setValue($json->value);
    }
    if(property_exists($json, 'enum')){
      $value->setEnum($json->enum);
    }
    if(property_exists($json, 'last_modified')){
      $value->setUpdated(new \DateTime('@' . $json->last_modified));
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
   * @param string $value
   */
  public function setValue($value){
    $this->value = $value;
  }

  /**
   * {@inheritdoc}
   */
  public function getValue(){
    return $this->value;
  }

  /**
   * @param string $enum
   */
  public function setEnum($enum){
    $this->enum = $enum;
  }

  /**
   * {@inheritdoc}
   */
  public function getEnum(){
    return $this->enum;
  }

  /**
   * {@inheritdoc}
   */
  public function getUpdated(){
    return $this->updated;
  }

  /**
   * @param \DateTime $updated
   */
  public function setUpdated(\DateTime $updated){
    $this->updated = $updated;
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
    if(!is_null($this->getValue())){
      $json['value'] = $this->getValue();
    }
    if(!is_null($this->getEnum())){
      $json['enum'] = $this->getEnum();
    }

    return $json;
  }
}
