<?php
namespace AmoCRMAPI\Account;

use AmoCRMAPI\User\User;
use AmoCRMAPI\CustomField\CustomField;
use AmoCRMAPI\CustomField\CustomFieldIterator;
use AmoCRMAPI\Lead\Status as LeadStatus;
use AmoCRMAPI\Lead\StatusIterator as LeadStatusIterator;

class Account implements AccountInterface{
  private $id;
  private $name;
  private $subdomain;
  private $currency;
  private $users;
  private $contactCustomFields;
  private $leadCustomFields;
  private $companyCustomFields;
  private $leadStatues;

  // Factories
  public static function jsonDecode($json){
    $value = new static;
    if(property_exists($json, 'id')){
      $value->setId((int) $json->id);
    }
    if(property_exists($json, 'name')){
      $value->setName($json->name);
    }
    if(property_exists($json, 'subdomain')){
      $value->setSubdomain($json->subdomain);
    }
    if(property_exists($json, 'currency')){
      $value->setCurrency((float) $json->currency);
    }
    if(property_exists($json, 'custom_fields')){
      if(property_exists($json->custom_fields, 'contacts') && is_array($json->custom_fields->contacts)){
        $value->setContactCustomFields(array_map(function($jsonCustomField){
          return CustomField::jsonDecode($jsonCustomField);
        }, $json->custom_fields->contacts));
      }
      if(property_exists($json->custom_fields, 'leads') && is_array($json->custom_fields->leads)){
        $value->setLeadCustomFields(array_map(function($jsonCustomField){
          return CustomField::jsonDecode($jsonCustomField);
        }, $json->custom_fields->leads));
      }
      if(property_exists($json->custom_fields, 'companies') && is_array($json->custom_fields->companies)){
        $value->setCompanyCustomFields(array_map(function($jsonCustomField){
          return CustomField::jsonDecode($jsonCustomField);
        }, $json->custom_fields->companies));
      }
    }
    if(property_exists($json, 'users')){
      $value->setUsers(array_map(function($jsonUser){
        return User::jsonDecode($jsonUser);
      }, $json->users));
    }
    if(property_exists($json, 'leads_statuses')){
      $value->setLeadStatues(array_map(function($jsonLeadStatus){
        return LeadStatus::jsonDecode($jsonLeadStatus);
      }, $json->leads_statuses));
    }

    return $value;
  }

  // Getters and Setters
  public function getId(){
    return $this->id;
  }

  public function setId($id){
    $this->id = $id;
  }

  public function getName(){
    return $this->name;
  }

  public function setName($name){
    $this->name = $name;
  }

  public function getSubdomain(){
    return $this->subdomain;
  }

  public function setSubdomain($subdomain){
    $this->subdomain = $subdomain;
  }

  public function getCurrency(){
    return $this->currency;
  }

  public function setCurrency($currency){
    $this->currency = $currency;
  }

  public function setUsers(array $users){
    $this->users = $users;
  }
  
  public function getUsers(){
    return $this->users;
  }

  public function getContactCustomFields(){
    return $this->contactCustomFields;
  }

  public function setContactCustomFields(array $contactCustomFields){
    $this->contactCustomFields = new CustomFieldIterator($contactCustomFields);
  }

  public function getLeadCustomFields(){
    return $this->leadCustomFields;
  }

  public function setLeadCustomFields(array $leadCustomFields){
    $this->leadCustomFields = new CustomFieldIterator($leadCustomFields);
  }

  public function getCompanyCustomFields(){
    return $this->companyCustomFields;
  }

  public function setCompanyCustomFields(array $companyCustomFields){
    $this->companyCustomFields = new CustomFieldIterator($companyCustomFields);
  }

  public function setLeadStatues(array $leadStatues){
    $this->leadStatues = new LeadStatusIterator($leadStatues);
  }
  
  public function getLeadStatues(){
    return $this->leadStatues;
  }
}
