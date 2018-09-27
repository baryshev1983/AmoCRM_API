<?php
namespace AmoCRMAPI\Pipeline;

use AmoCRMAPI\JsonDecodableInterface;

/**
 * @author Artur Sh. Mamedbekov
 */
interface PipelineInterface extends \JsonSerializable, JsonDecodableInterface{
  /**
   * @var int
   */
  public function getId();

  /**
   * @var string
   */
  public function getName();

  /**
   * @var int
   */
  public function getSort();

  /**
   * @var bool
   */
  public function isMain();

  /**
   * @var StatusInterface[]
   */
  public function getStatuses();
}
