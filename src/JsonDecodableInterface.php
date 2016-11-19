<?php
namespace AmoCRMAPI;

interface JsonDecodableInterface{
  /**
   * @return \stdClass $json
   *
   * @return static
   */
  public static function jsonDecode($json);
}
