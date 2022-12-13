<style>
	.collapse a {
		text-indent: 10px;
	}

	nav#sidebar {
		
		background-color:#333;
	}
</style>
<h1 class="mx-lt-5 bg-dark"><img src=""></h1>
<nav id="sidebar" class='mx-lt-5 bg-dark'>
<h1 class="text-center mb-5"><img src="assets/uploads/emprender.jpeg"  width="150px"></h1>

	<div class="sidebar-list">
		<a href="index.php?page=students" class="nav-item nav-students"><span class='icon-field'><i class="fa fa-users "></i></span> Estudiantes</a>
		<a href="index.php?page=fees" class="nav-item nav-fees"><span class='icon-field'><i class="fa fa-money-check "></i></span> Matriculas-Pagos</a>
		<a href="index.php?page=courses" class="nav-item nav-courses"><span class='icon-field'><i class="fa fa-scroll "></i></span>Inscripción</a>

		<a href="index.php?page=payments" class="nav-item nav-payments"><span class='icon-field'><i class="fa fa-receipt "></i></span> Pagos</a>

		<a href="index.php?page=payments_report" class="nav-item nav-payments_report"><span class='icon-field'><i class="fa fa-th-list"></i></span> Reportes de Pago</a>
		<?php if ($_SESSION['login_type'] == 1) : ?>
			<a href="index.php?page=users" class="nav-item nav-users"><span class='icon-field'><i class="fa fa-users "></i></span> Usuarios</a> <?php endif; ?>
	</div>

</nav>

<script>
	$('.nav_collapse').click(function() {
		console.log($(this).attr('href'))
		$($(this).attr('href')).collapse()
	})
	$('.nav-<?php echo isset($_GET['page']) ? $_GET['page'] : '' ?>').addClass('active')
</script>

