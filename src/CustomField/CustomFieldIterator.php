<?php
namespace AmoCMSAPI\CustomField;

/**
 * @author Artur Sh. Mamedbekov
 */
class CustomFieldIterator extends \ArrayIterator{
  public function fetchFromName($name){
    return array_pop(array_filter((array) $this, function($customField) use($name){
      return $customField->getName() == $name;
    }));
  }
}
