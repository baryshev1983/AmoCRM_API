<?php
namespace AmoCMSAPI; 

use AmoCMSAPI\Auth\AuthInterface;
use AmoCMSAPI\Auth\Auth;
use AmoCMSAPI\Auth\Proxy\SessionProxy as SessionProxyAuth;
use AmoCMSAPI\User\UserInterface;
use AmoCMSAPI\Account\Account;
use AmoCMSAPI\Contact\Contact;
use AmoCMSAPI\Lead\Lead;
use AmoCMSAPI\Task\Task;

/**
 * @author Artur Sh. Mamedbekov
 */
class Api{
  /**
   * @var ClientInterface
   */
  private $httpClient;

  /**
   * @var AuthInterface
   */
  private $auth;

  public static function getInstance(UserInterface $user, ClientInterface $httpClient){
    $auth = new Auth($user, $httpClient);

    return new self($httpClient, new SessionProxyAuth($auth));
  }

  private function getEntities($method, $limit, $offset, $responseProp, $entityClass){
    $request = $this->httpClient->createRequest($method, 'GET', [
      'limit_rows' => $limit,
      'limit_offset' => $offset,
    ])->withHeader('Cookie', 'session_id=' . $this->auth->getSsid());
    $response = $this->httpClient->sendRequest($request);
    $responseBody = json_decode($response->getBody()->getContents());
    if(is_null($responseBody) || !property_exists($responseBody->response, $responseProp)){
      return [];
    }

    return array_map(function($json) use($entityClass){
      return $entityClass::jsonDecode($json);
    }, $responseBody->response->$responseProp);
  }

  private function getEntity($method, $id, $responseProp, $entityClass){
    $request = $this->httpClient->createRequest($method, 'GET', [
      'id' => $id,
    ])->withHeader('Cookie', 'session_id=' . $this->auth->getSsid());
    $response = $this->httpClient->sendRequest($request);
    $responseBody = json_decode($response->getBody()->getContents());
    if(is_null($responseBody)){
      return null;
    }
    $entities = $responseBody->response->$responseProp;

    return $entityClass::jsonDecode($entities[0]);
  }

  private function saveEntities($method, array &$entities, $prop){
    $requestIndex = [];
    array_walk($entities, function($entity) use(&$requestIndex){
      if(!method_exists($entity, 'setRequestId')){
        return;
      }
      $requestIndex[] = $entity;
      $entity->setRequestId(key($requestIndex));
      next($requestIndex);
    });

    $request = $this->httpClient->createRequest(
      $method,
      'POST',
      [
        'request' => [
          $prop => [
            'add' => array_filter($entities, function($entity){
              return is_null($entity->getId());
            }),
            'update' => array_filter($entities, function($entity){
              return !is_null($entity->getId());
            }),
          ],
        ],
      ]
    )->withHeader('Cookie', 'session_id=' . $this->auth->getSsid());
    $response = $this->httpClient->sendRequest($request);
    $responseBody = json_decode($response->getBody()->getContents());
    
    $responseData = [];
    if(property_exists($responseBody->response->$prop, 'add')){
      $responseData = array_merge($responseData, $responseBody->response->$prop->add);
    }
    if(property_exists($responseBody->response->$prop, 'update')){
      $responseData = array_merge($responseData, $responseBody->response->$prop->update);
    }
    array_walk($responseData, function($data) use(&$requestIndex){
      if(!property_exists($data, 'request_id') || !isset($requestIndex[(int) $data->request_id])){
        return;
      }
      $entity = $requestIndex[(int) $data->request_id];
      $entity->setId((int) $data->id);
    });
  }

  public function __construct(ClientInterface $httpClient, AuthInterface $auth){
    $this->httpClient = $httpClient;
    $this->auth = $auth;
  }

  public function getAccount(){
    $request = $this->httpClient->createRequest('/private/api/v2/json/accounts/current', 'GET')
      ->withHeader('Cookie', 'session_id=' . $this->auth->getSsid());
    $response = $this->httpClient->sendRequest($request);
    $responseBody = json_decode($response->getBody()->getContents());

    return Account::jsonDecode($responseBody->response->account);
  }

  public function saveCustomFields(array $customFields){
    $this->saveEntities('/private/api/v2/json/fields/set', $customFields, 'fields');
  }

  public function getContacts($limit = 500, $offset = 0){
    return $this->getEntities('/private/api/v2/json/contacts/list', $limit, $offset, 'contacts', Contact::class);
  }

  public function getContact($id){
    return $this->getEntity('/private/api/v2/json/contacts/list', $id, 'contacts', Contact::class);
  }

  public function saveContacts(array $contacts){
    $this->saveEntities('/private/api/v2/json/contacts/set', $contacts, 'contacts');
  }

  public function getLeads($limit = 500, $offset = 0){
    return $this->getEntities('/private/api/v2/json/leads/list', $limit, $offset, 'leads', Lead::class);
  }

  public function getLead($id){
    return $this->getEntity('/private/api/v2/json/leads/list', $id, 'leads', Lead::class);
  }

  public function saveLeads(array $leads){
    $this->saveEntities('/private/api/v2/json/leads/set', $leads, 'leads');
  }

  public function getTasks($limit = 500, $offset = 0){
    return $this->getEntities('/private/api/v2/json/tasks/list', $limit, $offset, 'tasks', Task::class);
  }

  public function getTask($id){
    return $this->getEntity('/private/api/v2/json/tasks/list', $id, 'tasks', Task::class);
  }

  public function saveTasks(array $tasks){
    $this->saveEntities('/private/api/v2/json/tasks/set', $tasks, 'tasks');
  }
}
