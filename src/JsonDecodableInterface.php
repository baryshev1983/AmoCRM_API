<?php
namespace AmoCMSAPI;

interface JsonDecodableInterface{
  /**
   * @return \stdClass $json
   *
   * @return static
   */
  public static function jsonDecode($json);
}
