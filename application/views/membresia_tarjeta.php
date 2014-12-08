<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
			
		<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/normalize.css'); ?>">				
		<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/compra.css'); ?>">
		<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/comun.css'); ?>">
				 
		<title>Confirmación</title>
	</head>
	<body>
				<div class="membresia">
					<div class="nombre"><?php echo strtoupper($nombre); ?></div>
					<div class="plan"><?php echo $plan." - ".strtoupper($codigo); ?></div>
				</div>
		</div>
		<script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
		<script src="<?php echo base_url('assets/js/kembikio.js') ?>"></script>
	</body>
</html>