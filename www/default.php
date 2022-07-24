<?php
/* Add this on all pages on top. */
set_include_path($_SERVER['DOCUMENT_ROOT'].'/'.PATH_SEPARATOR.$_SERVER['DOCUMENT_ROOT'].'/library/classes/');

// Get the class file
require_once 'class/Employee.php';
// Get the object
$employeeObject = new Employee();
/* Setup Pagination. */
$filters = array(
 'dateOfBirth_like' => '-02-15', // date("-m-d"),
);

$employeeData = $employeeObject->getData($filters);
print_r($employeeData); exit;
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
      <div class="form-group">
       <button type="button" onclick="getRecords(); return false;" class="btn btn-primary">Search</button>
      </div>
      <div id="tableContent" class="table-responsive" align="center">
       <div class="table-responsive">  
       <table id="employee_data" class="table table-striped table-bordered">  
       <thead>  
       <tr>  
       <td>Full name</td>  
       <td>Date of Birth</td>  
       <td>Employment Start</td>  
       <td>Employment End</td>   
       </tr>  
       </thead>  
       <?php  
       while($row = mysqli_fetch_array($result))  
       {  
       echo '  
       <tr>  
       <td>'.$row["name"].'</td>  
       <td>'.$row["address"].'</td>  
       <td>'.$row["gender"].'</td>  
       <td>'.$row["designation"].'</td>  
       <td>'.$row["age"].'</td>  
       </tr>  
       ';  
       }  
       ?>  
       </table>  
       </div>  
      </div>
     </div>
    </div>
    <!-- table-wrapper -->
   </div><!-- section-wrapper -->
  </div><!-- container -->
 </div><!-- slim-mainpanel -->
	<?php require_once 'includes/footer.php'; ?>
</html>
