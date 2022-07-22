<?php
/* Add this on all pages on top. */
set_include_path($_SERVER['DOCUMENT_ROOT'].'/'.PATH_SEPARATOR.$_SERVER['DOCUMENT_ROOT'].'/library/classes/');

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
 
 public function getPagination(int $page = 1, int $limit = 20, array $filter = []) {
  
 }
}
