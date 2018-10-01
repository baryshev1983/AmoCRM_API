<?php
namespace AmoCRMAPI\Incoming;

/**
 * Информация о заявке типа - sip.
 *
 * @author Artur Sh. Mamedbekov
 */
interface SipInfoInterface extends InfoInterface{
  /**
   * @return int Идентификатор пользователя, принявшего звонок.
   */
  public function getTo();

  /**
   * @return string Внешний номер телефона, с которого поступил звонок.
   */
  public function getFrom();

  /**
   * @return DateTime Дата и время звонка.
   */
  public function getDateCall();

  /**
   * @return int Продолжительность звонка.
   */
  public function getDuration();

  /**
   * @return string Ссылка на запись звонка.
   */
  public function getLink();

  /**
   * @return string Код виджета, через который был совершен звонок.
   */
  public function getServiceCode();

  /**
   * @return string Уникальный код звонка.
   */
  public function getUniq();

  /**
   * @return string Текст события о завершении звонка при принятии заявки.
   */
  public function getAddNote();
}
