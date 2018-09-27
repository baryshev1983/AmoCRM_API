<?php
namespace AmoCRMAPI\Lead;

use AmoCRMAPI\JsonDecodableInterface;

/**
 * @author Artur Sh. Mamedbekov
 */
interface LeadInterface extends \JsonSerializable, JsonDecodableInterface{
  public function getId();

  public function getRequestId();

  public function getName();

  public function getPipelineId();

  public function getStatusId();

  public function getPrice();

  public function getResponsibleId();

  public function getTags();

  public function getCustomFields();

  public function getCreatorId();

  public function getAdded();

  public function getClosed();

  public function getUpdated();
}
