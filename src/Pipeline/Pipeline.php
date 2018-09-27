<?php
namespace AmoCRMAPI\Pipeline;

/**
 * @author Artur Sh. Mamedbekov
 */
class Pipeline implements PipelineInterface{
  /**
   * @var int
   */
  private $id;

  /**
   * @var string
   */
  private $name;

  /**
   * @var int
   */
  private $sort;

  /**
   * @var bool
   */
  private $isMain;

  /**
   * @var StatusInterface[]
   */
  private $statuses;

  public function __construct(){
    $this->statuses = [];
  }

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
    if(property_exists($json, 'sort')){
      $value->setSort((int) $json->sort);
    }
    if(property_exists($json, 'is_main')){
      $value->isMain = $json->is_main;
    }
    if(property_exists($json, 'statuses')){
      foreach($json->statuses as $jsonStatus){
        $value->statuses[] = Status::jsonDecode($jsonStatus);
      }
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
    if(!is_null($this->getSort())){
      $json['sort'] = $this->getSort();
    }
    if(!is_null($this->isMain)){
      $json['is_main'] = $this->isMain();
    }
    if(is_array($this->statuses) && count($this->statuses) > 0){
      $json['statuses'] = $this->statuses;
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
  public function isMain(){
    return $this->isMain;
  }

  /**
   * @param StatusInterface $status
   */
  public function addStatus(StatusInterface $status){
    $this->statuses[] = $status;
  }

  public function clearStatuses(){
    $this->statuses = [];
  }

  /**
   * {@inheritdoc}
   */
  public function getStatuses(){
    return $this->statuses;
  }
}
