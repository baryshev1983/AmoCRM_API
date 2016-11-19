<?php
namespace AmoCRMAPI\CustomField;

use AmoCRMAPI\JsonDecodableInterface;

/**
 * @author Artur Sh. Mamedbekov
 */
interface CustomFieldInterface extends \JsonSerializable, JsonDecodableInterface{
  /**
   * @return int
   */
  public function getId();

  /**
   * @return int
   */
  public function getRequestId();

  /**
   * @return string
   */
  public function getName();

  /**
   * @see CustomFieldType
   *
   * @return int
   */
  public function getType();

  /**
   * @see ElementType
   *
   * @return int
   */
  public function getElementType();

  /**
   * @return string
   */
  public function getOrigin();

  /**
   * @return bool
   */
  public function isDisabled();

  /**
   * @return ValueInterface[]
   */
  public function getValues();
}
