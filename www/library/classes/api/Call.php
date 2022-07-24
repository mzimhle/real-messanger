<?php
/* Add this on all pages on top. */
set_include_path($_SERVER['DOCUMENT_ROOT'].'/'.PATH_SEPARATOR.$_SERVER['DOCUMENT_ROOT'].'/library/classes/');

require_once 'Client.php';

/**
 * Call client requests easily
 * 
 * @author    Mzimhle Mosiwe
 *
 */
class Call extends Client
{
 /**
   * Initialize the calls
   *
   * @param string  $host
   * @param array   $headers
   */
 public function __construct($host, $headers = [])
 {
  parent::__construct($host, $headers);
 }
 /**
   * Get paginated list of employees
   *
   * @param int $page
   * @param int $limit
   * @param array $filter   
   *   
   * @param array $filter   
   *      
   */
 public function fetch(array $filters = []) {

  $arguments = '';
  $return = array();
  
  foreach($filters as $key => $value) {
   if(strpos($key, '_like') !== false) {
    $arguments .= ($arguments == '' ? '?' : '&').$key.'='.filter_var($value, FILTER_SANITIZE_STRING);;
   }
  }
  
  $returnData = $this->get($this->host.$arguments);

  if($returnData->statusCode() === 200) {
   $return = json_decode($returnData->body(), true);
  }
  return $return;
 }
}