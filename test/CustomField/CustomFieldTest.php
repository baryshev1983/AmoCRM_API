<?php
namespace AmoCMSAPITest\CustomField;

use AmoCMSAPI\CustomField\CustomField;
use AmoCMSAPI\CustomField\CustomFieldType;
use AmoCMSAPI\CustomField\ElementType;
use AmoCMSAPI\CustomField\Value;

/**
 * @author Artur Sh. Mamedbekov
 */
class CustomFieldTest extends \PHPUnit_Framework_TestCase{
  public function testJsonSerialize(){
    $value = new Value;
    $value->setId(1);
    $value->setValue('value');
    $value->setEnum('ENUM');
    $customField = new CustomField;
    $customField->setId(1);
    $customField->setRequestId(1);
    $customField->setName('name');
    $customField->setType(CustomFieldType::TEXT);
    $customField->setElementType(ElementType::CONTACT);
    $customField->setOrigin('origin');
    $customField->setDisabled(true);
    $customField->setValues([$value]);

    $this->assertEquals(
      '{"id":1,"request_id":1,"name":"name","type":1,"element_type":1,"origin":"origin","disabled":1,"values":[{"id":1,"value":"value","enum":"ENUM"}]}',
      json_encode($customField)
    );
  }

  public function testJsonDecode(){
    $assertValue = new Value;
    $assertValue->setId(1);
    $assertValue->setValue('value');
    $assertValue->setEnum('ENUM');
    $assertCustomField = new CustomField;
    $assertCustomField->setId(1);
    $assertCustomField->setRequestId(1);
    $assertCustomField->setName('name');
    $assertCustomField->setType(CustomFieldType::TEXT);
    $assertCustomField->setElementType(ElementType::CONTACT);
    $assertCustomField->setOrigin('origin');
    $assertCustomField->setDisabled(true);
    $assertCustomField->setValues([$assertValue]);

    $jsonValue = new \stdClass;
    $jsonValue->id = 1;
    $jsonValue->value = 'value';
    $jsonValue->enum = 'ENUM';
    $json = new \stdClass;
    $json->id = 1;
    $json->request_id = 1;
    $json->name = 'name';
    $json->type = 1;
    $json->element_type = 1;
    $json->origin = 'origin';
    $json->disabled = 1;
    $json->values = [$jsonValue];

    $this->assertEquals($assertCustomField, CustomField::jsonDecode($json));
  }
}
