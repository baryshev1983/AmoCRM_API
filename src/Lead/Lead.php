<?php
namespace AmoCRMAPI\Lead;

use AmoCRMAPI\Tag\Tag;
use AmoCRMAPI\CustomField\CustomField;

/**
 * @author Artur Sh. Mamedbekov
 */
class Lead implements LeadInterface{
  private $id;
  private $requestId;
  private $name;
  private $pipelineId;
  private $statusId;
  private $price;
  private $responsibleId;
  private $tags;
  private $customFields;
  private $creatorId;
  private $added;
  private $closed;
  private $updated;

  public function __construct(){
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
    if(property_exists($json, 'name')){
      $value->setName($json->name);
    }
    if(property_exists($json, 'pipeline_id')){
      $value->setPipelineId((int) $json->pipeline_id);
    }
    if(property_exists($json, 'status_id')){
      $value->setStatusId((int) $json->status_id);
    }
    if(property_exists($json, 'price')){
      $value->setPrice((float) $json->price);
    }
    if(property_exists($json, 'responsible_user_id')){
      $value->setResponsibleId((int) $json->responsible_user_id);
    }
    if(property_exists($json, 'created_user_id')){
      $value->setCreatorId((int) $json->created_user_id);
    }
    if(property_exists($json, 'date_create')){
      $value->setAdded(new \DateTime('@' . $json->date_create));
    }
    if(property_exists($json, 'date_close')){
      $value->setClosed(new \DateTime('@' . $json->date_close));
    }
    if(property_exists($json, 'last_modified')){
      $value->setUpdated(new \DateTime('@' . $json->last_modified));
    }
    if(property_exists($json, 'tags')){
      $value->setTags(array_map(function($jsonTag){
        return Tag::jsonDecode($jsonTag);
      }, $json->tags));
    }
    if(property_exists($json, 'custom_fields')){
      $value->setCustomFields(array_map(function($jsonCustomField){
        return CustomField::jsonDecode($jsonCustomField);
      }, $json->custom_fields));
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

  public function setName($name){
    $this->name = $name;
  }
  
  public function getName(){
    return $this->name;
  }

  public function setPipelineId($pipelineId){
    $this->pipelineId = $pipelineId;
  }
  
  public function getPipelineId(){
    return $this->pipelineId;
  }

  public function setStatusId($statusId){
    $this->statusId = $statusId;
  }
  
  public function getStatusId(){
    return $this->statusId;
  }

  public function setPrice($price){
    $this->price = $price;
  }
  
  public function getPrice(){
    return $this->price;
  }

  public function setResponsibleId($responsibleId){
    $this->responsibleId = $responsibleId;
  }
  
  public function getResponsibleId(){
    return $this->responsibleId;
  }

  public function setTags(array $tags){
    $this->tags = $tags;
  }
  
  public function getTags(){
    return $this->tags;
  }

  public function setCustomFields(array $customFields){
    $this->customFields = $customFields;
  }
  
  public function getCustomFields(){
    return $this->customFields;
  }

  public function setCreatorId($creatorId){
    $this->creatorId = $creatorId;
  }
  
  public function getCreatorId(){
    return $this->creatorId;
  }

  public function setAdded($added){
    $this->added = $added;
  }
  
  public function getAdded(){
    return $this->added;
  }

  public function setClosed($closed){
    $this->closed = $closed;
  }
  
  public function getClosed(){
    return $this->closed;
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
    if(!is_null($this->getName())){
      $json['name'] = $this->getName();
    }
    if(!is_null($this->getPipelineId())){
      $json['pipeline_id'] = $this->getPipelineId();
    }
    if(!is_null($this->getStatusId())){
      $json['status_id'] = $this->getStatusId();
    }
    if(!is_null($this->getPrice())){
      $json['price'] = $this->getPrice();
    }
    if(!is_null($this->getResponsibleId())){
      $json['responsible_user_id'] = $this->getResponsibleId();
    }
    if(!is_null($this->getCreatorId())){
      $json['created_user_id'] = $this->getCreatorId();
    }
    $json['last_modified'] = $this->getUpdated()->getTimestamp();
    $tags = $this->getTags();
    if(is_array($tags) && count($tags) > 0){
      $json['tags'] = array_map(function($tag){
        return $tag->getName();
      }, $tags);
      $json['tags'] = implode(',', $json['tags']);
    }
    $customFields = $this->getCustomFields();
    if(is_array($customFields) && count($customFields) > 0){
      $json['custom_fields'] = $this->getCustomFields();
    }

    return $json;
  }
}
