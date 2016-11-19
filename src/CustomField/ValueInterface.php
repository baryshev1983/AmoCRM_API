<?php
namespace AmoCMSAPI\CustomField;

use AmoCMSAPI\JsonDecodableInterface;

/**
 * @author Artur Sh. Mamedbekov
 */
interface ValueInterface extends \JsonSerializable, JsonDecodableInterface{
  /**
   * @return int|null
   */
  public function getId();

  /**
   * @return string
   */
  public function getValue();

  /**
   * @return string|null
   */
  public function getEnum();

  /**
   * @return \DateTime
   */
  public function getUpdated();
}
