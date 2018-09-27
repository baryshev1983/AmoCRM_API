<?php
namespace AmoCRMAPI\Pipeline;

use AmoCRMAPI\JsonDecodableInterface;

/**
 * @author Artur Sh. Mamedbekov
 */
interface StatusInterface extends \JsonSerializable, JsonDecodableInterface{
  /**
   * @var int
   */
  public function getId();

  /**
   * @var string
   */
  public function getName();

  /**
   * @var string
   */
  public function getColor();

  /**
   * @var int
   */
  public function getSort();

  /**
   * @var bool
   */
  public function isEditable();
}
