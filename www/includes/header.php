<?php
$page = explode('/',$_SERVER['REQUEST_URI']);
$currentPage = isset($page[1]) && trim($page[1]) != '' ? trim($page[1]) : '';
?>
<div class="slim-header">
  <div class="container">
	<div class="slim-header-left">
	  <h2 class="slim-logo"><a href="/">RealMessanger Assessment</a></h2>
	</div><!-- slim-header-left -->
  </div><!-- container -->
</div><!-- slim-header -->
<div class="slim-navbar">
  <div class="container">
	<ul class="nav">
	  <li class="nav-item <?php echo $currentPage == '' ? 'active' : ''; ?>">
		<a class="nav-link" href="/">
		  <i class="icon ion-ios-home-outline"></i>
		  <span>Dashboard</span>
		</a>
	</ul>
  </div><!-- container -->
</div><!-- slim-navbar -->
