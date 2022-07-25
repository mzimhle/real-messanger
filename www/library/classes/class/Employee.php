<?php
/* Add this on all pages on top. */
set_include_path($_SERVER['DOCUMENT_ROOT'].'/'.PATH_SEPARATOR.$_SERVER['DOCUMENT_ROOT'].'/library/classes/');

require_once 'Abstract/AbstractEmployee.php';
require_once 'api/Call.php';
require_once 'class/Comm.php';

/**
 *
 * Employee data class to save its objects
 *
 * @author     Mzimhle Mosiwe
 */

class Employee extends AbstractEmployee {

 /** @var Call */
 public $call;
 /** @var Comm */
 public $comm;
 /** @var host */
 private $host = 'https://interview-assessment-1.realmdigital.co.za/employees';
 
 /*
  * Initialize the employee
  */
 public function __construct()
 {
  $this->call = new Call($this->host);
  $this->comm = new Comm();  
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
  * Get the filtered data
  *  
  * @return string
  */
 public function getData(array $filters = []): ?array
 {
   $data = $this->call->fetch($filters);
   $return = array();
   
   foreach($data as $key => $value) {
    $return[] = $this->load($value);
   }
   return $return;
 }
 
/**
  *
  * Load data into instance of this class
  *  
  * @return this
  */
 public function load(array $values): Employee
 {
   $this->setId($values['id']);
   $this->setName($values['name']);
   $this->setLastName($values['lastname']);
   $this->setDateOfBirth($values['dateOfBirth']);
   $this->setEmploymentStartDate((isset($values['employmentStartDate']) ? $values['employmentStartDate'] : null));
   $this->setEmploymentEndDate((isset($values['employmentEndDate']) ? $values['employmentEndDate'] : null));
   $this->setLastNotification((isset($values['lastNotification']) ? $values['lastNotification'] : null));
   $this->setLastBirthdayNotified((isset($values['lastBirthdayNotified']) ? $values['lastBirthdayNotified'] : null));

   return $this;
 }
 
/**
  *
  * Load data into instance of this class
  *  
  * @return this
  */
 public function sendEmail(array $employeeData)
 {
  // Send message
  if(count($employeeData)) {
   foreach($employeeData as $employee) {
    if(null !== $employee->getLastBirthdayNotified() && $employee->getLastBirthdayNotified()->format('Y-m-d') != date("Y-m-d")) {
     $recipient = [
      'recipient_from_name' => 'mzimhle.mosiwe@gmail.com',
      'recipient_from_email' => 'Mzimhle Mosiwe',
      'recipient_name' => $employee->getName().' '.$employee->getLastName(),
      'recipient_email' => 'mzimhle.mosiwe@gmail.com',
      'dateOfBirth' => $employee->getDateOfBirth()->format('Y-m-d'),   
      'employmentEndDate' => (null !== $employee->getEmploymentEndDate() ? $employee->getEmploymentEndDate()->format('Y-m-d') : 'N/A'),
      'employmentStartDate' => (null !== $employee->getEmploymentStartDate() ? $employee->getEmploymentStartDate()->format('Y-m-d') : 'N/A'),
      'lastNotification' => (null !== $employee->getLastNotification() ? $employee->getLastNotification()->format('Y-m-d') : 'N/A'),
      'lastBirthdayNotified' => (null !== $employee->getLastBirthdayNotified() ? $employee->getLastBirthdayNotified()->format('Y-m-d') : 'N/A')
     ];
    }
   }
   
   
   
  }
 }
}