<?php
namespace AmoCRMAPI\Incoming;

use AmoCRMAPI\JsonDecodableInterface;

/**
 * Неразобранное.
 *
 * @author Artur Sh. Mamedbekov
 */
interface IncomingInterface extends \JsonSerializable, JsonDecodableInterface{
  /**
   * Не задано.
   */
  const CATEGORY_NULL = 'null';

  /**
   * Не определено.
   */
  const CATEGORY_UNDEFINED = 'undefined';

  /**
   * SIP.
   */
  const CATEGORY_SIP = 'sip';

  /**
   * Форма.
   */
  const CATEGORY_FORM = 'form';

  /**
   * @return string Идентификатор заявки.
   */
  public function getUid();

  /**
   * @return string Категория заявки.
   * @see CATEGORY_*
   */
  public function getCategory();

  /**
   * @return string Название источника заявки.
   */
  public function getSourceName();

  /**
   * @return string Уникальный идентификатор заявки
   */
  public function getSourceUid();

  /**
   * @return int Идентификатор воронки.
   */
  public function getPipelineId();

  /**
   * @return DateTime Дата создания.
   */
  public function getCreatedAt();

  /**
   * @return InfoInterface Информация о заявке.
   */
  public function getInfo();

  /**
   * @return ContactInterface[] Контакты, входящие в заявку.
   */
  public function getEntriesContacts();

  /**
   * @return LeadInterface[] Лиды, входящие в заявку.
   */
  public function getEntriesLeads();
}
