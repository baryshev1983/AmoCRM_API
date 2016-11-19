<?php
namespace AmoCMSAPI\Lead;

use AmoCMSAPI\JsonDecodableInterface;

/**
 * @author Artur Sh. Mamedbekov
 */
interface StatusInterface extends JsonDecodableInterface{
  public function getId();

  public function getName();

  public function getPipelineId();
}
