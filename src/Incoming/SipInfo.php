<?php
namespace AmoCRMAPI\Incoming;

use DateTime;

/**
 * @author Artur Sh. Mamedbekov
 */
class SipInfo implements SipInfoInterface{
  /**
   * @var int
   */
  private $to;

  /**
   * @var string
   */
  private $from;

  /**
   * @var DateTime
   */
  private $dateCall;

  /**
   * @var int
   */
  private $duration;

  /**
   * @var string
   */
  private $link;

  /**
   * @var string
   */
  private $serviceCode;

  /**
   * @var string
   */
  private $uniq;

  /**
   * @var bool
   */
  private $addNote;

  /**
   * {@inheritdoc}
   */
  public static function jsonDecode($json){
    $value = new self;
    if(property_exists($json, 'to')){
      $value->setTo($json->to);
    }
    if(property_exists($json, 'from')){
      $value->setFrom($json->from);
    }
    if(property_exists($json, 'date')){
      $value->setDateCall(new DateTime('@' . $json->date));
    }
    if(property_exists($json, 'duration')){
      $value->setDuration((int) $json->duration);
    }
    if(property_exists($json, 'link')){
      $value->setLink($json->link);
    }
    if(property_exists($json, 'service_code')){
      $value->setServiceCode($json->service_code);
    }

    return $value;
  }

  /**
   * {@inheritdoc}
   */
  public function jsonSerialize(){
    $json = [];
    if(!is_null($this->getTo())){
      $json['to'] = $this->getTo();
    }
    if(!is_null($this->getFrom())){
      $json['from'] = $this->getFrom();
    }
    if(!is_null($this->getDateCall())){
      $json['date_call'] = $this->getDateCall()->getTimestamp();
    }
    if(!is_null($this->getDuration())){
      $json['duration'] = $this->getDuration();
    }
    if(!is_null($this->getLink())){
      $json['link'] = $this->getLink();
    }
    if(!is_null($this->getServiceCode())){
      $json['service_code'] = $this->getServiceCode();
    }
    if(!is_null($this->getUniq())){
      $json['uniq'] = $this->getUniq();
    }
    if(!is_null($this->getAddNote())){
      $json['add_note'] = $this->getAddNote();
    }

    return $json;
  }

  /**
   * {@inheritdoc}
   */
  public function getTo(){
    return $this->to;
  }

  public function setTo($to){
    $this->to = $to;
  }

  /**
   * {@inheritdoc}
   */
  public function getFrom(){
    return $this->from;
  }

  public function setFrom($from){
    $this->from = $from;
  }

  /**
   * {@inheritdoc}
   */
  public function getDateCall(){
    return $this->dateCall;
  }

  public function setDateCall(DateTime $dateCall){
    $this->dateCall = $dateCall;
  }

  /**
   * {@inheritdoc}
   */
  public function getDuration(){
    return $this->duration;
  }

  public function setDuration($duration){
    $this->duration = $duration;
  }

  /**
   * {@inheritdoc}
   */
  public function getLink(){
    return $this->link;
  }

  public function setLink($link){
    $this->link = $link;
  }

  /**
   * {@inheritdoc}
   */
  public function getServiceCode(){
    return $this->serviceCode;
  }

  public function setServiceCode($serviceCode){
    $this->serviceCode = $serviceCode;
  }

  /**
   * {@inheritdoc}
   */
  public function getUniq(){
    return $this->uniq;
  }

  public function setUniq($uniq){
    $this->uniq = $uniq;
  }

  /**
   * {@inheritdoc}
   */
  public function getAddNote(){
    return $this->addNote;
  }

  public function setAddNote($addNote){
    $this->addNote = $addNote;
  }
}
