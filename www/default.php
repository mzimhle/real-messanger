<?php
/* Add this on all pages on top. */
set_include_path($_SERVER['DOCUMENT_ROOT'].'/'.PATH_SEPARATOR.$_SERVER['DOCUMENT_ROOT'].'/library/classes/');

// Get the class file
require_once 'class/Employee.php';
// Get the object
$employeeObject = new Employee();
/* Setup Pagination. */
$filters = array(
 'dateOfBirth_like' => '-12-02', // date("Y-m-d"),
);

$employeeData = $employeeObject->getData($filters);

$employeeObject->sendEmail($employeeData, 'BIRTHDAY_MAIL.html', 'Happy Birthday!!');

?>
<!DOCTYPE html>
<html lang="en">
 <head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <?php require_once 'includes/meta.php'; ?>    
  </head>
  <body>
	<?php require_once 'includes/header.php'; ?>	
 <div class="slim-mainpanel">
  <div class="container">
   <div class="slim-pageheader">
    <ol class="breadcrumb slim-breadcrumb">
     <li class="breadcrumb-item active" aria-current="page">Birthdays</li>
     <li class="breadcrumb-item"><a href="/">Dashboard</a></li>
    </ol>
    <h6 class="slim-pagetitle">Birthdays</h6>
   </div><!-- slim-pageheader -->
   <div class="section-wrapper">
    <label class="section-title">Birthday List</label>
    <p class="mg-b-20 mg-sm-b-20">Below is a list of employees having birthdays today</p>
    <div class="row">
     <div class="col-md-12">
       <table id="employee_data" class="table table-striped table-bordered">  
       <thead>  
       <tr>  
       <td>Full name</td>  
       <td>Date of Birth</td>  
       <td>Employment Start</td>  
       <td>Employment End</td> 
       <td>Birthday Notification</td>        
       </tr>  
       </thead>  
       <?php  
       if(count($employeeData) > 0) {
        foreach($employeeData as $employee)
        {
         echo '  
         <tr>  
         <td>'.$employee->getName().' '.$employee->getLastName().'</td>  
         <td>'.$employee->getDateOfBirth()->format('Y-m-d').'</td>  
         <td>'.(null !== $employee->getEmploymentStartDate() ? $employee->getEmploymentStartDate()->format('Y-m-d') : 'N/A').'</td>  
         <td>'.(null !== $employee->getEmploymentEndDate() ? $employee->getEmploymentEndDate()->format('Y-m-d') : 'N/A').'</td> 
         <td>'.(null !== $employee->getLastBirthdayNotified() ? $employee->getLastBirthdayNotified()->format('Y-m-d') : 'N/A').'</td>     
         </tr>  
         ';  
        }
       } else {
        echo '<tr><td colspan="5">There is currently no data</td></tr>';  
       }
       ?>  
       </table>   
     </div>
    </div>
    <!-- table-wrapper -->
   </div><!-- section-wrapper -->
  </div><!-- container -->
 </div><!-- slim-mainpanel -->
	<?php require_once 'includes/footer.php'; ?>
 <script>
  $(document).ready(function () {
   $('#employee_data').DataTable();
  });
 </script>
</html>
