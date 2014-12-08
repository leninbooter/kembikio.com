<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />

		<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/comun.css'); ?>">				
		<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/normalize.css'); ?>">				
		<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/compra.css'); ?>">
		<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/responsive.css'); ?>">
				 
		<title><?php echo $title; ?></title>
	</head>
	<body>
		<div id="errores" class="errores" style="display: none"><div id="mensaje"><img src="<?php echo base_url('assets/imagenes/advertencia.png');?>"/></div></div>
		<div id="contenido">
			<ul id="compra_lineatemporal">
				<li class="actual">
						<div>
							<h1>Información Personal</h1>						
							<a>1</a>
						</div>
				</li><li class="">
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
			<form id="form_reg_pedido" method="POST" action="<?php echo base_url('index.php/tienda/registrar_orden'); ?>">
				<table>
					<tr>
						<th>Descripción</th><th>Precio</th><th>Total a pagar</th>
					</tr>
					<?php $i = 1; ?>
					<?php foreach ($this->cart->contents() as $items): ?>
						<input type="hidden" id="servicio_id" name="servicio_id" value="<?php echo $items['id']; ?>">
						<tr>
							<td><?php echo $items['name']; ?></td><td><?php echo $this->cart->format_number( $items['price'] ) . " " . $this->session->userdata('moneda_simbolo'); ?></td>
							<td>
								<?php echo $this->cart->format_number($items['subtotal']); ?>							
								<input type="hidden" id="subtotal" name="subtotal" value="<?php echo $items['subtotal']; ?>">
								<input type="hidden" id="imp" name="imp" value="0">
								<input type="hidden" id="total" name="total" value="<?php echo $this->cart->total();?>">
								<?php
									if( $this->cart->product_options( $items['rowid'] )['moneda_cod_local'] == $this->session->userdata('moneda_cod_local') )
									{
										echo $this->session->userdata('moneda_simbolo');
									}
								?>
							</td>
						</tr>
						<?php $i++; ?>
					<?php endforeach; ?>
				</table>
				<div class="form_pedido">
					<div class="form">
						<fieldset>
							<div>
								<label>Nombre y Apellido:<span class="requerido">*</span></label>
								<input name="nombre" id="nombre" type="text" maxlength="50"/><input name="apellido" id="apellido" type="text" maxlength="50" />
							</div>
							<div>
								<label>E-mail:<span class="requerido">*</span></label><input name="email" id="email" type="text" maxlength="200" />						
							</div>
							<div>
								<label>Confirmación de e-mail:<span class="requerido">*</span></label><input name="email_conf" id="email_conf" type="text" maxlength="200"/>						
							</div>
							<div>
								<label>Dirección:<span class="requerido">*</span></label><input name="direccion" id="direccion" type="text" maxlength="200"/><input name="cp" id="cp" type="text" value="C.P." maxlength="5"/><span> Madrid - España</span>
							</div>
							<div>
								<label>Número de Teléfono:<span class="requerido">*</span></label><input name="telefono" id="telefono" type="text" maxlength="20"/>						
							</div>							
						</fieldset>
						<div class="base_controles">
							<button>Continuar</button>
						</div>
					</div>
					<div class="info">
					</div>
				</div>
			</form>
		</div>
		<script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
		<script src="<?php echo base_url('assets/js/kembikio.js') ?>"></script>
	</body>
</html>