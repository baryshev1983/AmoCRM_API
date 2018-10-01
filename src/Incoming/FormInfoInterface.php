<?php
namespace AmoCRMAPI\Incoming;

/**
 * Информация о заявке типа - form.
 *
 * @author Artur Sh. Mamedbekov
 */
interface FormInfoInterface extends InfoInterface{
  /**
   * @return string Уникальный идентификатор формы.
   */
  public function getFormId();

  /**
   * @return string Адрес страницы, на которой расположена форма.
   */
  public function getFormPage();

  /**
   * @return string IP-адрес, с которого поступила заявка.
   */
  public function getIP();

  /**
   * @return string Код виджета или сервиса.
   */
  public function getServiceCode();

  /**
   * @return string Название формы.
   */
  public function getFormName();

  /**
   * @return DateTime Дата и время отправки данных через форму.
   */
  public function getFormSendAt();

  /**
   * @return string Реферер страницы, предшествующей переходу на форму.
   */
  public function getReferer();
}
