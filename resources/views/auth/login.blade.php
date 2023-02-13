<!DOCTYPE html>
<html lang="en">

<head>

	<title>Sistema de inventario - Ponce Producciones</title>	
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<meta name="description" content="" />
	<meta name="keywords" content="">
	<meta name="author" content="Phoenixcoded" />

	<!-- Favicon icon -->
	<link rel="icon" href="{{ asset('images/favicon.svg') }}" type="image/x-icon">

	<!-- font css -->
	<link rel="stylesheet" href="{{ asset('fonts/font-awsome-pro/css/pro.min.css') }}">
	<link rel="stylesheet" href="{{ asset('fonts/feather.css') }}">
	<link rel="stylesheet" href="{{ asset('fonts/fontawesome.css') }}">

	<!-- vendor css -->
	<link rel="stylesheet" href="{{ asset('css/style.css') }}">
	<link rel="stylesheet" href="{{ asset('css/customizer.css') }}">


</head>

<!-- [ auth-signin ] start -->
<div class="auth-wrapper">
	<div class="auth-content">
		<div class="card">
			<div class="row align-items-center text-center">
				<div class="col-md-12">
					<div class="card-body">
						<img src="{{ asset('images/logo-ponce-dark.svg') }}" style="width: 180px" alt="" class="img-fluid mb-4">
						<h4 class="mb-3 f-w-400">Ingreso al sistema</h4>
						<div class="input-group mb-3">
							<div class="input-group-prepend">
								<span class="input-group-text"><i data-feather="mail"></i></span>
							</div>
							<input type="email" class="form-control" placeholder="usuario">
						</div>
						<div class="input-group mb-4">
							<div class="input-group-prepend">
								<span class="input-group-text"><i data-feather="lock"></i></span>
							</div>
							<input type="password" class="form-control" placeholder="Contraseña">
						</div>
						<!-- <div class="form-group text-left mt-2">
							<div class="custom-control custom-checkbox">
								<input type="checkbox" class="custom-control-input input-primary" id="customCheckdefh2" checked="">
								<label class="custom-control-label" for="customCheckdefh2">Guardar credenciales</label>
							</div>
						</div> -->
						<button class="btn btn-block btn-primary mb-4">Iniciar Sesión</button>
						<!-- <p class="mb-0 text-muted">Don’t have an account? <a href="auth-signup.html" class="f-w-400">Signup</a></p> -->
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- [ auth-signin ] end -->

<!-- Required Js -->
<script src="{{ asset('js/vendor-all.min.js') }}"></script>
<script src="{{ asset('js/plugins/bootstrap.min.js') }}"></script>
<script src="{{ asset('js/plugins/feather.min.js') }}"></script>
<script src="{{ asset('js/pcoded.min.js') }}"></script>
<!-- <script>
    $("body").append('<div class="fixed-button active"><a href="https://1.envato.market/VGznk" target="_blank" class="btn btn-md btn-success"><i class="fa fa-shopping-cart" aria-hidden="true"></i> Upgrade To Pro</a> </div>');
</script> -->


</body>

</html>
