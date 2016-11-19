<?php
namespace AmoCMSAPI\Tag;

use AmoCMSAPI\JsonDecodableInterface;

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
