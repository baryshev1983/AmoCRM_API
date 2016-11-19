<?php
namespace AmoCRMAPITest;

use AmoCRMAPI\Api;
use AmoCRMAPI\User\User;
use AmoCRMAPI\CurlClient;
use AmoCRMAPI\CustomField\CustomField;
use AmoCRMAPI\CustomField\CustomFieldType;
use AmoCRMAPI\CustomField\ElementType;
use AmoCRMAPI\CustomField\Value;
use AmoCRMAPI\Tag\Tag;
use AmoCRMAPI\Contact\Contact;
use AmoCRMAPI\Contact\ContactType;
use AmoCRMAPI\Lead\Lead;

/**
 * @author Artur Sh. Mamedbekov
 */
class ApiTest extends \PHPUnit_Framework_TestCase{
  const DEFAULT_SUBDOMAIN = '';

  // Factories
  public function createClient($subdomain = null){
    return new CurlClient(is_null($subdomain)? self::DEFAULT_SUBDOMAIN : $subdomain);
  }

  public function createApi($client = null){
    if(is_null($client)){
      $client = $this->createClient();
    }
    return Api::getInstance(new User('artur-mamedbekov@yandex.ru', 'e1e50b06e9aad1dd265d239258089c0f'), $client);
  }

  // Tests
  /*
  public function testGetAccount(){
    $api = $this->createApi();
  
    var_dump($api->getAccount());
  }
  */

  /*
  public function testSaveCustomFields(){
    $customField = new CustomField;
    $customField->setName('name');
    $customField->setRequestId(1);
    $customField->setDisabled(false);
    $customField->setType(CustomFieldType::TEXT);
    $customField->setElementType(ElementType::LEAD);
    $customField->setOrigin('origin');
  
    $api = $this->createApi();
    $api->saveCustomFields([$customField]);
  }
  */

  /*
  public function testGetContacts(){
    $api = $this->createApi();
  
    var_dump($api->getContacts());
  }
  */

  /*
  public function testGetContact(){
    $api = $this->createApi();
  
    var_dump($api->getContact(12464814));
  }
  */

  /*
  public function testSaveContacts(){
    $api = $this->createApi();
  
    $account = $api->getAccount();
  
    $contacts = [];
    $contact = new Contact;
    $contact->setName('Test Testovich2');
    $contact->setType(ContactType::CONTACT);
    $emailCustomField = $account->getContactCustomFields()->fetchFromName('Email');
    $emailCustomField->setValues([new Value('test@test.ru', 'WORK')]);
    $contact->setCustomFields([$emailCustomField]);
    $contact->setTags([new Tag('test')]);
    $contacts[] = $contact;
  
    $api->saveContacts($contacts);
    var_dump($contacts);
  }
  */

  /*
  public function testGetLeads(){
    $api = $this->createApi();
  
    var_dump($api->getLeads());
  }
  */

  /*
  public function testGetLead(){
    $api = $this->createApi();
  
    var_dump($api->getLead(5099994));
  }
  */

  /*
  public function testSaveLeads(){
    $api = $this->createApi();
  
    $account = $api->getAccount();
  
  
    $leads = [];
    $lead = new Lead;
    $lead->setName('Test lead');
    $lead->setStatusId($account->getLeadStatues()->fetchFromName('Согласование договора'));
    $lead->setPrice(15.5);
    $lead->setTags([new Tag('test')]);
    $leads[] = $lead;
  
    $api->saveLeads($leads);
    var_dump($leads);
  }
  */

  /*
  public function testGetTasks(){
    $api = $this->createApi();
  
    var_dump($api->getTasks());
  }
  */
}
