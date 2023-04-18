<!-- [ navigation menu ] start -->
<nav class="pc-sidebar ">
		<div class="navbar-wrapper">
			<div class="m-header">
				<a href="index.html" class="b-brand">
					<!-- ========   change your logo hear   ============ -->
					<img src="{{ asset('images/logo.png') }}" style = "width: 120px" alt="" class="logo logo-lg">
					<!-- <img src="{{ asset('images/logo-sm.svg') }}" alt="" class="logo logo-sm"> -->
				</a>
			</div>
			<div class="navbar-content">
				<ul class="pc-navbar">
					<li class="pc-item pc-caption">
						<label>Administración</label>
					</li>
					<li class="pc-item">
						<a href="{{ route('panel') }}" class="pc-link "><span class="pc-micon"><i data-feather="home"></i></span><span class="pc-mtext">Dashboard</span></a>
					</li>
					<li class="pc-item pc-caption">
						<label>Inventario</label>
						<span>Administra tus productos</span>
					</li>
					<li class="pc-item pc-hasmenu">
						<a class="pc-link "><span class="pc-micon"><i data-feather="box"></i></span><span class="pc-mtext">Inventario</span><span class="pc-arrow"><i data-feather="chevron-right"></i></span></a>
						<ul class="pc-submenu">
							<li class="pc-item"><a class="pc-link" href="{{ route('product') }}">Productos</a></li>
							<li class="pc-item"><a class="pc-link" href="{{ route('category') }}">Categorias</a></li>							
							<!-- <li class="pc-item"><a class="pc-link" href="bc_alert.html">Solicitudes</a></li> -->
							<li class="pc-item"><a class="pc-link" href="{{ route('store') }}">Almacén</a></li>
							<li class="pc-item"><a class="pc-link" href="{{ route('brand') }}">Marcas</a></li>
							<li class="pc-item"><a class="pc-link" href="{{ route('supplier') }}">Proveedores</a></li>														
						</ul>
					</li>
					<li class="pc-item">
						<a href="{{ route('worker') }}" class="pc-link "><span class="pc-micon"><i data-feather="users"></i></span><span class="pc-mtext">RR.HH</span></a>
					</li>					

				</ul>				
			</div>
		</div>
	</nav>
	<!-- [ navigation menu ] end -->