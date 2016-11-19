<?php
namespace AmoCRMAPI\Task;

use AmoCRMAPI\JsonDecodableInterface;

/**
 * @author Artur Sh. Mamedbekov
 */
interface TaskInterface extends \JsonSerializable, JsonDecodableInterface{
  public function getId();

  public function getRequestId();

  public function getElementId();

  public function getElementType();

  /**
   * @see TaskType
   *
   * @return string
   */
  public function getType();

  public function getText();

  public function getResponsibleId();

  public function isComplete();

  public function getCreatorId();

  public function getCompleteTill();

  public function getAdded();

  public function getUpdated();
}
