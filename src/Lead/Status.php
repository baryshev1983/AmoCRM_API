<?php
namespace AmoCMSAPI\Lead;

/**
 * @author Artur Sh. Mamedbekov
 */
class Status implements StatusInterface{
  private $id;
  private $name;
  private $pipelineId;

  // Factories
  public static function jsonDecode($json){
    $value = new self;
    if(property_exists($json, 'id')){
      $value->setId((int) $json->id);
    }
    if(property_exists($json, 'name')){
      $value->setName($json->name);
    }
    if(property_exists($json, 'pipeline_id')){
      $value->setPipelineId((int) $json->pipeline_id);
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
}
