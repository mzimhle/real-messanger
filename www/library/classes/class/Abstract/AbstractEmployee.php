<?php

/**
 *
 * Employee data class to save its objects
 *
 * @author     Mzimhle Mosiwe
 */

class AbstractEmployee {
  /** @var id */
  protected $id;
  /** @var string */  
  protected $name;
  /** @var string */    
  protected $lastname;
  /** @var DateTime */      
  protected $dateOfBirth;
  /** @var DateTime */      
  protected $employmentStartDate;
  /** @var DateTime|null */    
  protected $employmentEndDate;
  /** @var DateTime|null */    
  protected $lastNotification;
  /** @var DateTime|null */    
  protected $lastBirthdayNotified;

 /**
  * Constructor of the class.
  */
  function __construct() 
  {

  }
 /**
  * @return int
  */
  function getId(): int 
  {
   return $this->id;
  }
 /**
  * @return string
  */
  function getName(): string
  {
   return $this->name;
  }
 /**
  * @return string|null
  */
  function getLastName(): ?string 
  {
   return $this->lastname;
  }  
 /**
  * @return \DateTime
  */
  function getDateOfBirth(): \DateTime
  {
   return $this->dateOfBirth;
  }      
 /**
  * @return \DateTime
  */
  function getEmploymentStartDate(): \DateTime 
  {
   return $this->employmentStartDate;
  }
 /**
  * @return \DateTime|null
  */
  function getEmploymentEndDate(): ?\DateTime
  {
   return $this->employmentEndDate;
  }
 /**
  * @return \DateTime|null
  */
  function getLastNotification(): ?\DateTime
  {
   return $this->lastNotification;
  }
 /**
  * @return \DateTime|null
  */
  function getLastBirthdayNotified(): ?\DateTime
  {
   return $this->lastBirthdayNotified;
  }

 /**
  * @param int $id
  * @return Employee
  */
  function setId(int $id): Employee 
  {
   $this->id = $id;
   return $this;
  }
 /**
  * @param string $name
  * @return Employee
  */
  function setName(string $name): Employee 
  {
   $this->name = $name;
   return $this;
  }
 /**
  * @param \DateTime $lastname
  * @return Employee
  */
  function setLastName(string $lastname): Employee 
  {
   $this->lastname = $lastname;
   return $this;
  }  
 /**
  * @param \DateTime $dateOfBirth
  * @return Employee
  */
  function setDateOfBirth(?string $dateOfBirth): Employee
  {
   if($dateOfBirth === null || $dateOfBirth === '') {
    $variable = null;
   } else {
    $variable = new DateTime($dateOfBirth);   
   }      
   $this->dateOfBirth = $variable;
   return $this;
  }      
 /**
  * @param \DateTime $employmentStartDate
  * @return Employee
  */
  function setEmploymentStartDate(?string $employmentStartDate): Employee
  {
   if($employmentStartDate === null || $employmentStartDate === '') {
    $variable = null;
   } else {
    $variable = new DateTime($employmentStartDate);   
   }     
   $this->employmentStartDate = $variable;
   return $this;
  }
 /**
  * @param \DateTime $employmentEndDate
  * @return Employee
  */
  function setEmploymentEndDate(?string $employmentEndDate): Employee 
  {
   if($employmentEndDate === null || $employmentEndDate === '') {
    $variable = null;
   } else {
    $variable = new DateTime($employmentEndDate);   
   }     
   $this->employmentEndDate = $variable;
   return $this;
  }
 /**
  * @param \DateTime $lastNotification
  * @return Employee
  */
  function setLastNotification(?string $lastNotification): Employee
  {
   if($lastNotification === null || $lastNotification === '') {
    $variable = null;
   } else {
    $variable = new DateTime($lastNotification);   
   }

   $this->lastNotification = $variable;
   return $this;
  }
 /**
  * @param \DateTime $lastBirthdayNotified
  * @return Employee
  */
  function setLastBirthdayNotified(?string $lastBirthdayNotified): Employee 
  {
   if($lastBirthdayNotified === null || $lastBirthdayNotified === '') {
    $variable = null;
   } else {
    $variable = new DateTime($lastBirthdayNotified);   
   }
   $this->lastBirthdayNotified = $variable;
   return $this;
  }      
}