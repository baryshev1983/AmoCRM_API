<?php
namespace AmoCRMAPI\Incoming;

use AmoCRMAPI\Lead\Lead;
use AmoCRMAPI\Contact\Contact;
use DateTime;

/**
 * @author Artur Sh. Mamedbekov
 */
class Incoming implements IncomingInterface{
  private $uid;

  private $sourceName;

  private $sourceUid;

  private $pipelineId;

  private $createdAt;

  private $info;

  private $entriesContacts;

  private $entriesLeads;

  public function __construct(){
    $this->entriesContacts = [];
    $this->entriesLeads = [];
  }

  /**
   * {@inheritdoc}
   */
  public static function jsonDecode($json){
    $value = new self;
    if(property_exists($json, 'uid')){
      $value->setUid($json->uid);
    }
    if(property_exists($json, 'source_name')){
      $value->setSourceName($json->source_name);
    }
    if(property_exists($json, 'source_uid')){
      $value->setSourceUid($json->source_uid);
    }
    if(property_exists($json, 'created_at')){
      $value->setCreatedAt(new DateTime('@' . $json->created_at));
    }
    if(property_exists($json, 'incoming_lead_info')){
      switch($json->category){
        case IncomingInterface::CATEGORY_SIP:
            $value->setInfo(FormInfo::jsonDecode($json->incoming_lead_info));
            break;
        case IncomingInterface::CATEGORY_FORM:
            $value->setInfo(SipInfo::jsonDecode($json->incoming_lead_info));
            break;
      }
    }
    if(property_exists($json, 'incoming_entities')){
      if(property_exists($json->incoming_entities, 'contacts')){
        $value->entriesContacts = array_map(function($contactJson){
          return Contact::jsonDecode($contactJson);
        }, $json->incoming_entities->contacts);
      }
      if(property_exists($json->incoming_entities, 'leads')){
        $value->entriesLeads = array_map(function($leadJson){
          return Lead::jsonDecode($leadJson);
        }, $json->incoming_entities->leads);
      }
    }

    return $value;
  }

  /**
   * {@inheritdoc}
   */
  public function jsonSerialize(){
    $json = [];
    if(!is_null($this->getSourceName())){
      $json['source_name'] = $this->getSourceName();
    }
    if(!is_null($this->getSourceUid())){
      $json['source_uid'] = $this->getSourceUid();
    }
    if(!is_null($this->getPipelineId())){
      $json['pipeline_id'] = $this->getPipelineId();
    }
    if(!is_null($this->getCreatedAt())){
      $json['created_at'] = $this->getCreatedAt()->getTimestamp();
    }
    if(!is_null($this->getInfo())){
      $json['incoming_lead_info'] = $this->getInfo();
    }
    $json['incoming_entities'] = [];
    if(count($this->entriesContacts) > 0){
      $json['incoming_entities']['contacts'] = $this->entriesContacts;
    }
    if(count($this->entriesLeads) > 0){
      $json['incoming_entities']['leads'] = $this->entriesLeads;
    }

    return $json;
  }
  
  /**
   * {@inheritdoc}
   */
  public function getUid(){
    return $this->uid;
  }

  public function setUid($uid){
    $this->uid = $uid;
  }

  /**
   * {@inheritdoc}
   */
  public function getCategory(){
    if(is_null($this->info)){
      return IncomingInterface::CATEGORY_NULL;
    }

    if($this->info instanceof FormInfoInterface){
      return IncomingInterface::CATEGORY_FORM;
    }
    elseif($this->info instanceof SipInfoInterface){
      return IncomingInterface::CATEGORY_SIP;
    }
    else{
      return IncomingInterface::CATEGORY_UNDEFINED;
    }
  }

  /**
   * {@inheritdoc}
   */
  public function getSourceName(){
    return $this->sourceName;
  }

  public function setSourceName($sourceName){
    $this->sourceName = $sourceName;
  }

  /**
   * {@inheritdoc}
   */
  public function getSourceUid(){
    return $this->sourceUid;
  }

  public function setSourceUid($sourceUid){
    $this->sourceUid = $sourceUid;
  }

  /**
   * {@inheritdoc}
   */
  public function getPipelineId(){
    return $this->pipelineId;
  }

  public function setPipelineId($pipelineId){
    $this->pipelineId = $pipelineId;
  }

  /**
   * {@inheritdoc}
   */
  public function getCreatedAt(){
    return $this->createdAt;
  }

  public function setCreatedAt(DateTime $createdAt){
    $this->createdAt = $createdAt;
  }
  
  /**
   * {@inheritdoc}
   */
  public function getInfo(){
    return $this->info;
  }

  public function setInfo(InfoInterface $info){
    $this->info = $info;
  }

  /**
   * {@inheritdoc}
   */
  public function getEntriesContacts(){
    return $this->entriesContacts;
  }

  public function setEntriesContacts(array $entriesContacts){
    $this->entriesContacts = $entriesContacts;
  }

  /**
   * {@inheritdoc}
   */
  public function getEntriesLeads(){
    return $this->entriesLeads;
  }

  public function setEntriesLeads(array $entriesLeads){
    $this->entriesLeads = $entriesLeads;
  }
}
