<?php
namespace AmoCMSAPI\Lead;

/**
 * @author Artur Sh. Mamedbekov
 */
class StatusIterator extends \ArrayIterator{
  public function fetchFromName($name){
    return array_pop(array_filter((array) $this, function($status) use($name){
      return $status->getName() == $name;
    }));
  }
}
