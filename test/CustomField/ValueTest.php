<?php
namespace AmoCRMAPITest\CustomField;

use AmoCRMAPI\CustomField\Value;

/**
 * @author Artur Sh. Mamedbekov
 */
class ValueTest extends \PHPUnit_Framework_TestCase{
  public function testJsonSerialize(){
    $value = new Value;
    $value->setId(1);
    $value->setValue('test');
    $value->setEnum('PHONE');
    $this->assertEquals('{"id":1,"value":"test","enum":"PHONE"}', json_encode($value));
  }

  public function testJsonDecode(){
    $assertValue = new Value;
    $assertValue->setId(1);
    $assertValue->setValue('test');
    $assertValue->setEnum('PHONE');
    $assertValue->setUpdated(new \DateTime('@' . 1));
    $json = new \stdClass;
    $json->id = 1;
    $json->value = 'test';
    $json->enum = 'PHONE';
    $json->last_modified = 1;

    $this->assertEquals($assertValue, Value::jsonDecode($json));
  }
}
