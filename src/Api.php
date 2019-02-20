<?php
namespace AmoCRMAPI; 

use Zend\Diactoros\Request;
use Zend\Diactoros\Stream;
use AmoCRMAPI\Auth\AuthInterface;
use AmoCRMAPI\Auth\Auth;
use AmoCRMAPI\Auth\Proxy\SessionProxy as SessionProxyAuth;
use AmoCRMAPI\User\UserInterface;
use AmoCRMAPI\Account\Account;
use AmoCRMAPI\Pipeline\Pipeline;
use AmoCRMAPI\Contact\Contact;
use AmoCRMAPI\Lead\Lead;
use AmoCRMAPI\Task\Task;
use AmoCRMAPI\Incoming\IncomingInterface;
use AmoCRMAPI\Incoming\Incoming;

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

	private function getEntities($method, $params, $limit, $offset, $responseProp, $entityClass)
	{
		$data = [
			'limit_rows' => $limit,
			'limit_offset' => $offset,
		];

		$request = $this->httpClient->createRequest($method, 'GET', array_merge($data, $params))->withHeader('Cookie', 'session_id=' . $this->auth->getSsid());
		$response = $this->httpClient->sendRequest($request);
		$responseBody = json_decode($response->getBody()->getContents());

    if(!$responseBody){
			return [];
		}

    if(property_exists($responseBody, 'response')){
      $responseItems = $responseBody->response;
    }
    elseif(property_exists($responseBody, '_embedded')){
      $responseItems = $responseBody->_embedded;
    }
    else{
      return [];
    }

    $result = [];
    foreach($responseItems->$responseProp as $json){
      $result[] = $entityClass::jsonDecode($json);
    }
    return $result;
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
    if(is_null($responseBody) || !property_exists($responseBody->response, $prop)){
      return;
    }
    
    $responseData = [];
    if(property_exists($responseBody->response->$prop, 'add')
        && !empty($responseBody->response->$prop->add)
    ){
      $responseData = array_merge($responseData, (array)$responseBody->response->$prop->add);
    }
    if(property_exists($responseBody->response->$prop, 'update')
        && !empty($responseBody->response->$prop->update)
    ){
      $responseData = array_merge($responseData, (array)$responseBody->response->$prop->update);
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

  public function getPipelines(){
		return $this->getEntities('/private/api/v2/json/pipelines/list', [], 500, 0, 'pipelines', Pipeline::class);
  }

  public function savePipelines(array $pipelines){
		$this->saveEntities('/private/api/v2/json/pipelines/set', $pipelines, 'pipelines');
  }

  public function getContacts($limit = 500, $offset = 0, $params = []){
    return $this->getEntities('/private/api/v2/json/contacts/list', $params, $limit, $offset, 'contacts', Contact::class);
  }

  public function getContact($id){
    return $this->getEntity('/private/api/v2/json/contacts/list', $id, 'contacts', Contact::class);
  }

  public function saveContacts(array $contacts){
    $this->saveEntities('/private/api/v2/json/contacts/set', $contacts, 'contacts');
  }

  public function getLeads($limit = 500, $offset = 0, $params = []){
    return $this->getEntities('/private/api/v2/json/leads/list', $params, $limit, $offset, 'leads', Lead::class);
  }

  public function getLead($id){
    return $this->getEntity('/private/api/v2/json/leads/list', $id, 'leads', Lead::class);
  }

  public function saveLeads(array $leads){
    $this->saveEntities('/private/api/v2/json/leads/set', $leads, 'leads');
  }

  public function getTasks($limit = 500, $offset = 0, $params = []){
    return $this->getEntities('/private/api/v2/json/tasks/list', $params, $limit, $offset, 'tasks', Task::class);
  }

  public function getTask($id){
    return $this->getEntity('/private/api/v2/json/tasks/list', $id, 'tasks', Task::class);
  }

  public function saveTasks(array $tasks){
    $this->saveEntities('/private/api/v2/json/tasks/set', $tasks, 'tasks');
  }

  public function getIncomings($limit = 500, $offset = 0, $params = []){
    return $this->getEntities(
      '/api/v2/incoming_leads',
      array_merge(
        $params,
        [
          'login' => $this->auth->getUser()->getLogin(),
          'api_key' => $this->auth->getUser()->getHash(),
        ]
      ),
      $limit,
      $offset,
      'items',
      Incoming::class
    );
  }

  /**
   * Добавляет заявки в неразобранное. Все заявки должны быть одной категории.
   */
  public function saveIncomings(array $incomings){
    if(count($incomings) == 0){
      return;
    }

    $uri = '';
    switch($incomings[0]->getCategory()){
      case IncomingInterface::CATEGORY_SIP:
        $uri = '/api/v2/incoming_leads/sip';
        break;
      case IncomingInterface::CATEGORY_FORM:
        $uri = '/api/v2/incoming_leads/form';
        break;
      default:
        return;
    }

    $body = new Stream('php://temp', 'w+');
    $body->write(
      http_build_query([
        'add' => json_decode(json_encode($incomings), true)
      ])
    );
    $request = new Request(
      sprintf(
        'https://%s.amocrm.ru%s?%s',
        $this->httpClient->getSubdomain(),
        $uri,
        http_build_query([
          'login' => $this->auth->getUser()->getLogin(),
          'api_key' => $this->auth->getUser()->getHash(),
        ])
      ),
      'POST',
      $body,
      [
        'Cookie' => 'session_id=' . $this->auth->getSsid(),
      ]
    );
		$response = $this->httpClient->sendRequest($request);
		$responseBody = json_decode($response->getBody()->getContents(), true);
		if (is_null($responseBody) || !isset($responseBody['data'])) {
			return;
		}

    foreach($responseBody['data'] as $i => $uid){
      $incomings[$i]->setUid($uid);
    }
  }

  /**
   * @param string[] $uids Идентификаторы принимаемых заявок.
   * @param int $userId Идентификатор пользователя, от имени которого будет 
   * принята заявка.
   * @param int $statusId Идентификатор этапа, в которых будут созданы принятые 
   * сделки.
   *
   * @return array Созданные из заявки сущности. Структура:
   * {
   *   uid: {
   *     contacts: [contactId, ...],
   *     leads: [leadId, ...],
   *     companies: [companyId, ...]
   *   },
   *   ...
   * }
   */
  public function acceptIncoming(array $uids, $userId, $statusId){
    $body = new Stream('php://temp', 'w+');
    $body->write(
      http_build_query([
        'accept' => $uids,
        'user_id' => $userId,
        'status_id' => $statusId,
      ])
    );
    $request = new Request(
      sprintf(
        'https://%s.amocrm.ru/api/v2/incoming_leads/accept?%s',
        $this->httpClient->getSubdomain(),
        http_build_query([
          'login' => $this->auth->getUser()->getLogin(),
          'api_key' => $this->auth->getUser()->getHash(),
        ])
      ),
      'POST',
      $body,
      [
        'Cookie' => 'session_id=' . $this->auth->getSsid(),
      ]
    );
		$response = $this->httpClient->sendRequest($request);
		$responseBody = json_decode($response->getBody()->getContents(), true);
		if (is_null($responseBody) || !isset($responseBody['data'])) {
			return;
		}

    return $responseBody['data'];
  }

  /**
   * @param string[] $uids Идентификаторы отклоняемых заявок.
   * @param int $userId Идентификатор пользователя, от имени которого будет 
   * отклонена заявка.
   */
  public function declineIncoming(array $uids, $userId){
    $body = new Stream('php://temp', 'w+');
    $body->write(
      http_build_query([
        'decline' => $uids,
        'user_id' => $userId,
      ])
    );
    $request = new Request(
      sprintf(
        'https://%s.amocrm.ru/api/v2/incoming_leads/decline?%s',
        $this->httpClient->getSubdomain(),
        http_build_query([
          'login' => $this->auth->getUser()->getLogin(),
          'api_key' => $this->auth->getUser()->getHash(),
        ])
      ),
      'POST',
      $body,
      [
        'Cookie' => 'session_id=' . $this->auth->getSsid(),
      ]
    );
		$this->httpClient->sendRequest($request);
  }
}
