<?php
namespace AmoCRMAPI\Incoming;

use DateTime;

/**
 * @author Artur Sh. Mamedbekov
 */
class FormInfo implements FormInfoInterface{
  /**
   * @var string
   */
  private $formId;

  /**
   * @var stirng
   */
  private $formPage;

  /**
   * @var string
   */
  private $ip;

  /**
   * @var string
   */
  private $serviceCode;

  /**
   * @var string
   */
  private $formName;

  /**
   * @var DateTime
   */
  private $formSendAt;

  /**
   * @var string
   */
  private $referer;

  /**
   * {@inheritdoc}
   */
  public static function jsonDecode($json){
    $value = new self;
    if(property_exists($json, 'form_id')){
      $value->setFormId($json->form_id);
    }
    if(property_exists($json, 'form_name')){
      $value->setFormName($json->form_name);
    }
    if(property_exists($json, 'form_page')){
      $value->setFormPage($json->form_page);
    }
    if(property_exists($json, 'form_send_at')){
      $value->setFormSendAt(new DateTime('@' . $json->form_send_at));
    }
    if(property_exists($json, 'ip')){
      $value->setIP($json->ip);
    }
    if(property_exists($json, 'service_code')){
      $value->setServiceCode($json->service_code);
    }
    if(property_exists($json, 'referer')){
      $value->setReferer($json->referer);
    }

    return $value;
  }

  /**
   * {@inheritdoc}
   */
  public function jsonSerialize(){
    $json = [];
    if(!is_null($this->getFormId())){
      $json['form_id'] = $this->getFormId();
    }
    if(!is_null($this->getFormPage())){
      $json['form_page'] = $this->getFormPage();
    }
    if(!is_null($this->getIP())){
      $json['ip'] = $this->getIP();
    }
    if(!is_null($this->getServiceCode())){
      $json['service_code'] = $this->getServiceCode();
    }
    if(!is_null($this->getFormName())){
      $json['form_name'] = $this->getFormName();
    }
    if(!is_null($this->getFormSendAt())){
      $json['form_send_at'] = $this->getFormSendAt()->getTimestamp();
    }
    if(!is_null($this->getReferer())){
      $json['referer'] = $this->getReferer();
    }

    return $json;
  }

  /**
   * {@inheritdoc}
   */
  public function getFormId(){
    return $this->formId;
  }

  public function setFormId($formId){
    $this->formId = $formId;
  }

  /**
   * {@inheritdoc}
   */
  public function getFormPage(){
    return $this->formPage;
  }

  public function setFormPage($formPage){
    $this->formPage = $formPage;
  }

  /**
   * {@inheritdoc}
   */
  public function getIP(){
    return $this->ip;
  }

  public function setIP($ip){
    $this->ip = $ip;
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
  public function getFormName(){
    return $this->formName;
  }

  public function setFormName($formName){
    $this->formName = $formName;
  }

  /**
   * {@inheritdoc}
   */
  public function getFormSendAt(){
    return $this->formSendAt;
  }

  public function setFormSendAt(DateTime $formSendAt){
    $this->formSendAt = $formSendAt;
  }

  /**
   * {@inheritdoc}
   */
  public function getReferer(){
    return $this->referer;
  }

  public function setReferer($referer){
    $this->referer = $referer;
  }
}
