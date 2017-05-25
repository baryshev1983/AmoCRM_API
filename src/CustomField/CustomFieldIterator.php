<?php
namespace AmoCRMAPI\CustomField;

/**
 * @author Artur Sh. Mamedbekov
 */
class CustomFieldIterator extends \ArrayIterator{
  public function fetchFromName($name){
    $customField = array_filter((array) $this, function($customField) use($name){
      return $customField->getName() == $name;
    });

    return array_pop($customField);
  }
}
