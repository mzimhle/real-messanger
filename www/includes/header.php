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
	  </li>
	  <li class="nav-item <?php echo $currentPage == 'member' ? 'active' : ''; ?>">
		<a class="nav-link" href="/member/">
		  <i class="icon ion-ios-analytics-outline"></i>
		  <span>Members</span>
		</a>
	  </li>
	  <li class="nav-item <?php echo $currentPage == 'animal' ? 'active' : ''; ?>">
		<a class="nav-link" href="/animal/">
		  <i class="icon ion-ios-analytics-outline"></i>
		  <span>Animals</span>
		</a>
	  </li>
	</ul>
  </div><!-- container -->
</div><!-- slim-navbar -->
