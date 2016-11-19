<?php
namespace AmoCRMAPI\Task;

class Task implements TaskInterface{
  private $id;
  private $requestId;
  private $elementId;
  private $elementType;
  private $type;
  private $text;
  private $responsibleId;
  private $isComplete;
  private $creatorId;
  private $completeTill;
  private $added;
  private $updated;

  public function __construct(){
    $this->isComplete = false;
    $this->added = new \DateTime;
    $this->updated = new \DateTime;
  }

  // Factories
  public static function jsonDecode($json){
    $value = new self;
    if(property_exists($json, 'id')){
      $value->setId((int) $json->id);
    }
    if(property_exists($json, 'request_id')){
      $value->setRequestId((int) $json->request_id);
    }
    if(property_exists($json, 'element_id')){
      $value->setElementId((int) $json->element_id);
    }
    if(property_exists($json, 'element_type')){
      $value->setElementType((int) $json->element_type);
    }
    if(property_exists($json, 'task_type')){
      $value->setType($json->task_type);
    }
    if(property_exists($json, 'text')){
      $value->setText($json->text);
    }
    if(property_exists($json, 'responsible_user_id')){
      $value->setResponsibleId((int) $json->responsible_user_id);
    }
    if(property_exists($json, 'is_complete')){
      $value->setIsComplete((bool) $json->is_complete);
    }
    if(property_exists($json, 'created_user_id')){
      $value->setCreatorId((int) $json->created_user_id);
    }
    if(property_exists($json, 'complete_till')){
      $value->setCompleteTill(new \DateTime('@' . $json->complete_till));
    }
    if(property_exists($json, 'date_create')){
      $value->setAdded(new \DateTime('@' . $json->date_create));
    }
    if(property_exists($json, 'last_modified')){
      $value->setUpdated(new \DateTime('@' . $json->last_modified));
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

  public function setRequestId($requestId){
    $this->requestId = $requestId;
  }
  
  public function getRequestId(){
    return $this->requestId;
  }

  public function setElementId($elementId){
    $this->elementId = $elementId;
  }
  
  public function getElementId(){
    return $this->elementId;
  }

  public function setElementType($elementType){
    $this->elementType = $elementType;
  }
  
  public function getElementType(){
    return $this->elementType;
  }

  public function setType($type){
    $this->type = $type;
  }
  
  public function getType(){
    return $this->type;
  }

  public function setText($text){
    $this->text = $text;
  }
  
  public function getText(){
    return $this->text;
  }

  public function setResponsibleId($responsibleId){
    $this->responsibleId = $responsibleId;
  }
  
  public function getResponsibleId(){
    return $this->responsibleId;
  }

  public function setIsComplete($isComplete){
    $this->isComplete = $isComplete;
  }
  
  public function isComplete(){
    return $this->isComplete;
  }

  public function setCreatorId($creatorId){
    $this->creatorId = $creatorId;
  }
  
  public function getCreatorId(){
    return $this->creatorId;
  }

  public function setCompleteTill($completeTill){
    $this->completeTill = $completeTill;
  }
  
  public function getCompleteTill(){
    return $this->completeTill;
  }

  public function setAdded($added){
    $this->added = $added;
  }
  
  public function getAdded(){
    return $this->added;
  }

  public function setUpdated($updated){
    $this->updated = $updated;
  }
  
  public function getUpdated(){
    return $this->updated;
  }

  // Other
  public function jsonSerialize(){
    $json = [];
    if(!is_null($this->getId())){
      $json['id'] = $this->getId();
    }
    if(!is_null($this->getRequestId())){
      $json['request_id'] = $this->getRequestId();
    }
    if(!is_null($this->getElementId())){
      $json['element_id'] = $this->getElementId();
    }
    if(!is_null($this->getElementType())){
      $json['element_type'] = $this->getElementType();
    }
    if(!is_null($this->getType())){
      $json['task_type'] = $this->getType();
    }
    if(!is_null($this->getText())){
      $json['text'] = $this->getText();
    }
    if(!is_null($this->getResponsibleId())){
      $json['responsible_user_id'] = $this->getResponsibleId();
    }
    if(!is_null($this->isComplete())){
      $json['is_complete'] = $this->isComplete();
    }
    if(!is_null($this->getCreatorId())){
      $json['created_user_id'] = $this->getCreatorId();
    }
    $json['last_modified'] = $this->getUpdated()->getTimestamp();
    if(!is_null($this->completeTill())){
      $json['complete_till'] = $this->getCompleteTill()->getTimestamp();
    }

    return $json;
  }
}
