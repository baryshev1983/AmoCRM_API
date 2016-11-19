<?php
namespace AmoCRMAPI\Tag;

use AmoCRMAPI\JsonDecodableInterface;

interface TagInterface extends JsonDecodableInterface{
  /**
   * @return int
   */
  public function getId();

  /**
   * @return string
   */
  public function getName();
}
