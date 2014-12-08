<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />

		<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/comun.css'); ?>">				
		<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/normalize.css'); ?>">				
		<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/compra.css'); ?>">
		<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/responsive.css'); ?>">
				 
		<title>Confirmación</title>
	</head>
	<body>
		<div id="errores" class="errores" style="display: none"><div id="mensaje"><img src="<?php echo base_url('assets/imagenes/advertencia.png');?>"/></div></div>
		<div id="contenido">
			<ul id="compra_lineatemporal">
				<li class="completado">
						<div>
							<h1>Información Personal</h1>						
							<a>1</a>
						</div>
				</li><li class="actual">
						<div>
							<h1>Pago</h1>
							<a>2</a>
						</div>
				</li><li class="">
						<div>	
							<h1>Completado</h1>
							<a>3</a>
						</div>
						</li>
			</ul>								
				
				<div class="message">
					<h1><?php echo $nombre; ?>, el banco no ha autorizado el pago. Vuelve a realizar el pedido.</h1>
				</div>		
				<div class="boton_descarga">
					<a href="<?php echo base_url('index.php/informacion/planes'); ?>">Volver al inicio</a>							
				</div>
		</div>
		<script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
		<script src="<?php echo base_url('assets/js/kembikio.js') ?>"></script>
	</body>
</html>