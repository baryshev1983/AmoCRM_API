<?php
namespace AmoCMSAPI\Account;

use AmoCMSAPI\JsonDecodableInterface;

/**
 * @author Artur Sh. Mamedbekov
 */
interface AccountInterface extends JsonDecodableInterface{
  public function getId();

  public function getName();

  public function getSubdomain();

  public function getCurrency();

  public function getContactCustomFields();

  public function getLeadCustomFields();

  public function getCompanyCustomFields();
}
