<?php
namespace AmoCMSAPI\CustomField;

/**
 * @author Artur Sh. Mamedbekov
 */
abstract class CustomFieldType{
  const TEXT = 1;
  const NUMERIC = 2;
  const CHECKBOX = 3;
  const SELECT = 4;
  const MULTISELECT = 5;
  const DATE = 6;
  const URL = 7;
  const MULTITEXT = 8;
  const TEXTAREA = 9;
  const RADIOBUTTON = 10;
  const STREETADDRESS = 11;
  const SMART_ADDRESS = 13;
  const BIRTHDAY = 14;
}
