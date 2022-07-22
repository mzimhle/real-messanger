<?php
/* Add this on all pages on top. */
set_include_path($_SERVER['DOCUMENT_ROOT'].'/'.PATH_SEPARATOR.$_SERVER['DOCUMENT_ROOT'].'/library/classes/');

require_once 'Abstract/AbstractEmployee.php';
require_once 'api/Call.php';
/**
 *
 * Employee data class to save its objects
 *
 * @author     Mzimhle Mosiwe
 */

class Employee extends AbstractEmployee {
 /** @var Call */
 protected $call;
 
 /**
  * 
  * @param Patient $patient
  * @param HealthService $healthService
  */
 public function __construct()
 {
  
  $this->call = new Call();
  
  parent::__construct();
 }
 
 /**
  *
  * Return name and surname of the employee should object need to be converted to a string.
  *  
  * @return string
  */
 public function __toString(): string
 {
  return ucwords(strtolower((sprintf('%s %s', $this->name, $this->lastname))));
 }
 
 /**
  *
  * Load returned data into the current object.
  *  
  * @return Employee|null
  */
 public function load(array $data): ?Employee
 {
  
 }
}