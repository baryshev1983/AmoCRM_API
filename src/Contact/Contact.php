<?php
namespace AmoCMSAPI\Contact;

use AmoCMSAPI\Tag\Tag;
use AmoCMSAPI\CustomField\CustomField;

/**
 * @author Artur Sh. Mamedbekov
 */
class Contact implements ContactInterface{
  private $id;
  private $requestId;
  private $name;
  private $type;
  private $companyName;
  private $leadsId;
  private $tags;
  private $customFields;
  private $creatorId;
  private $added;
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
    if(property_exists($json, 'type')){
      $value->setType($json->type);
    }
    if(property_exists($json, 'company_name')){
      $value->setCompanyName($json->company_name);
    }
    if(property_exists($json, 'created_user_id')){
      $value->setCreatorId((int) $json->created_user_id);
    }
    if(property_exists($json, 'date_create')){
      $value->setAdded(new \DateTime('@' . $json->date_create));
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
  /**
   * {@inheritdoc}
   */
  public function getId(){
    return $this->id;
  }

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

  public function setName($name){
    $this->name = $name;
  }

  /**
   * {@inheritdoc}
   */
  public function getType(){
    return $this->type;
  }

  public function setType($type){
    $this->type = $type;
  }

  /**
   * {@inheritdoc}
   */
  public function getCompanyName(){
    return $this->companyName;
  }

  public function setCompanyName($companyName){
    $this->companyName = $companyName;
  }

  /**
   * {@inheritdoc}
   */
  public function getLeadsId(){
  }

  /**
   * {@inheritdoc}
   */
  public function getTags(){
    return $this->tags;
  }

  public function setTags(array $tags){
    $this->tags = $tags;
  }

  /**
   * {@inheritdoc}
   */
  public function getCustomFields(){
    return $this->customFields;
  }

  public function setCustomFields(array $customFields){
    $this->customFields = $customFields;
  }

  /**
   * {@inheritdoc}
   */
  public function getCreatorId(){
    return $this->creatorId;
  }

  public function setCreatorId($creatorId){
    $this->creatorId = $creatorId;
  }

  /**
   * {@inheritdoc}
   */
  public function getAdded(){
    return $this->added;
  }

  public function setAdded($added){
    $this->added = $added;
  }

  /**
   * {@inheritdoc}
   */
  public function getUpdated(){
    return $this->updated;
  }

  public function setUpdated($updated){
    $this->updated = $updated;
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
    if(!is_null($this->getCompanyName())){
      $json['company_name'] = $this->getCompanyName();
    }
    $json['last_modified'] = $this->getUpdated()->getTimestamp();
    if(count($tags = $this->getTags())){
      $json['tags'] = array_map(function($tag){
        return $tag->getName();
      }, $tags);
      $json['tags'] = implode(',', $json['tags']);
    }
    if(count($customFields = $this->getCustomFields())){
      $json['custom_fields'] = $this->getCustomFields();
    }

    return $json;
  }
}
