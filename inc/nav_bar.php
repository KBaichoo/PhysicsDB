<?php


 ?>
	<nav class="navbar navbar-default" role="navigation">
	  <div class="container">
	    <div class="container-fluid">
	      <!-- Brand and toggle get grouped for better mobile display -->
	      <div class="navbar-header">
	        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
	          <span class="sr-only">Toggle navigation</span>
	          <span class="icon-bar"></span>
	          <span class="icon-bar"></span>
	          <span class="icon-bar"></span>
	        </button>
	        <a class="navbar-brand" href="index1.php">Physics System</a>
	      </div>

	      <!-- Collect the nav links, forms, and other content for toggling -->
	      <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
	        <ul class="nav navbar-nav navbar-left">
	          <li><a href="equipment_list.php">Equipment</a></li>
	          <li><a href='admin.php'>My Account!</a></li>
						<?php if(isset($_SESSION['user']) && ($_SESSION['level'] == "admin") || ($_SESSION['level'] == "superadmin")){ ?>

							<li>
							<a href='admin.php?manage=accounts'>Manage Accounts</a>
							</li>
							<li class="dropdown">
				        <a href="#" class="dropdown-toggle" data-toggle="dropdown">Manage Items<b class="caret"></b></a>
				        <ul class="dropdown-menu">
				          <li><a href="admin.php?manage=items&operation=cd">Create and Delete Items</a></li>
				          <li><a href="admin.php?manage=items&operation=iu">Place Items</a></li>
				          <li><a href="admin.php?manage=items&operation=bulk">Bulk Operations</a></li>
				        </ul>
				      </li>

						<?php } ?>
						<li><a href="logout.php">Logout</a></li>      
	        </ul>
	      </div><!-- /.navbar-collapse -->
	    </div><!-- /.container-fluid -->
	  </div>
	</nav>
