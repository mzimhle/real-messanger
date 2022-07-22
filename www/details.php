<?php
/* Add this on all pages on top. */
set_include_path($_SERVER['DOCUMENT_ROOT'].'/'.PATH_SEPARATOR.$_SERVER['DOCUMENT_ROOT'].'/library/classes/');
// Get the class file
require_once 'request.php';
// Get the object
$requestObject = new Request('member');
// Check if we are updating
if(isset($_GET['id']) && trim($_GET['id']) != '') {

	$id			= (int)trim($_GET['id']);
	$memberData	= $requestObject->getId($id);
	// Check if we all good
	if(!$memberData) {
		header('Location: /member/');
		exit;		
	}
}
/* Check posted data. */
if(count($_POST) > 0) {

	$errors	= array();

	if(!isset($_POST['name'])) {
		$errors[] = 'Please add name of the member';	
	} else if(trim($_POST['name']) == '') {
		$errors[] = 'Please add name of the member';	
	}
	
	if(!isset($_POST['cellphone'])) {
		$errors[] = 'Please add format of the member statement';	
	} else if(trim($_POST['cellphone']) == '') {
		$errors[] = 'Please add format of the member statement';	
	}

	if(count($errors) == 0) {
		/* Add the details. */
		$data				= array();				
		$data['name']      	= trim($_POST['name']);
        $data['cellphone']	= trim($_POST['cellphone']);
		$data['email']    	= trim($_POST['email']);
		/* Insert or update. */
		if(!isset($memberData)) {
			/* Insert */
			$success = $requestObject->insert($data);
		} else {
			$success = $requestObject->update($data, $memberData['id']);				
		}
		// Check if all is good.
		if((int)$success['code'] != 200) {
			$errors[] = $success['message'];	
		}
	}
	/* Check errors and redirect if there are non. */
	if(count($errors) == 0) {
		header('Location: /member/');
		exit;
	} else {
		$errors = implode('<br />', $errors);
	}
}
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
			<?php if(isset($memberData)) { ?>
			<li class="breadcrumb-item active" aria-current="page">Edit</li>
			<li class="breadcrumb-item"><?php echo $memberData['name']; ?></li>
			<?php } else { ?>
			<li class="breadcrumb-item active" aria-current="page">Add</li>
			<?php } ?>
			<li class="breadcrumb-item"><a href="/member/">Member</a></li>
            <li class="breadcrumb-item"><a href="/">Dashboard</a></li>
          </ol>
          <h6 class="slim-pagetitle">Member</h6>
        </div><!-- slim-pageheader -->
        <div class="section-wrapper">
			<label class="section-title"><?php echo (isset($memberData) ? 'Update member' : 'Add member'); ?></label>
			<p class="mg-b-20 mg-sm-b-10">Below is where you add or update the member's details</p>		
          <div class="row">
			<div class="col-md-12 col-lg-12 mg-t-20 mg-md-t-0-force">
            <?php if(isset($errors)) { ?><div class="alert alert-danger" role="alert"><strong><?php echo $errors; ?></strong></div><?php } ?>
            <form action="/member/details.php<?php echo (isset($memberData) ? '?id='.$memberData['id'] : ''); ?>" method="POST">
                <div class="row">					
                    <div class="col-sm-6">			  
                        <div class="form-group has-error">
                            <label for="name">Name</label>
                            <input type="text" id="name" name="name" class="form-control" value="<?php echo (isset($memberData) ? $memberData['name'] : ''); ?>" />
                            <code>Please add the name of the member</code>									
                        </div>
                    </div>
                    <div class="col-sm-6">			  
                        <div class="form-group">
                            <label for="cellphone">Cellphone Number</label>
                            <input type="text" id="cellphone" name="cellphone" class="form-control" value="<?php echo (isset($memberData) ? $memberData['cellphone'] : ''); ?>" />
                            <code>Please add a valid South African cellphone number with 10 digits</code>									
                        </div>
                    </div>
                </div>
                <div class="row">					
                    <div class="col-sm-12">			  
                        <div class="form-group has-error">
                            <label for="email">Email Address</label>
                            <input type="text" id="email" name="email" class="form-control" value="<?php echo (isset($memberData) ? $memberData['email'] : ''); ?>" />
                            <code>OPTIONAL: Please add a valid email address of the member</code>									
                        </div>
                    </div>
                </div>				
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-actions text">
                            <input type="submit" value="<?php echo (isset($memberData) ? 'Update' : 'Add'); ?>" class="btn btn-primary">
                        </div>
                    </div>
                </div>
            </form>
            </div><!-- col-4 -->
          </div><!-- row -->
        </div><!-- section-wrapper -->
      </div><!-- container -->
    </div><!-- slim-mainpanel -->
	<?php require_once 'includes/footer.php'; ?>	
  </body>
</html>
