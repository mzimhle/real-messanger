<?php
/* Add this on all pages on top. */
set_include_path($_SERVER['DOCUMENT_ROOT'].'/'.PATH_SEPARATOR.$_SERVER['DOCUMENT_ROOT'].'/library/classes/');
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
    <div class="page-error-wrapper">
      <div>
        <h1 class="error-title">404</h1>
        <h5 class="tx-sm-24 tx-normal">Oopps. The page you were looking for doesn't exist.</h5>
        <p class="mg-b-50">You may have mistyped the address or the page may have moved.</p>
        <p class="mg-b-50"><a href="/" class="btn btn-error">Back to Home</a></p>
      </div>
    </div><!-- page-error-wrapper -->
	<?php require_once 'includes/footer.php'; ?>
  </body>
</html>
