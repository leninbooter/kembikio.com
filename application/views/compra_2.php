<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />

		<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/comun.css'); ?>">				
		<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/normalize.css'); ?>">				
		<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/compra.css'); ?>">
		<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/responsive.css'); ?>">
				 
		<title>Contratación de Servicio - Paso 2</title>
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
				<table>
					<tr>
						<th>Descripción</th><th>Precio</th><th>Total a pagar</th>
					</tr>
					<?php $i = 1; ?>
					<?php foreach ($this->cart->contents() as $items): ?>
						<input type="hidden" id="servicio_id" name="servicio_id" value="<?php echo $items['id']; ?>"/>
						<tr>
							<td><?php echo $items['name']; ?></td><td><?php echo $this->cart->format_number( $items['price'] ) . " " . $this->session->userdata('moneda_simbolo'); ?></td>
							<td>
								<?php echo $this->cart->format_number($items['subtotal']); ?>														<input type="hidden" id="total" name="total" value="<?php echo $this->cart->total();?>">
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
				<div class="message">
					<h1>¡<?php echo $nombre ?>, ya solo falta pagar tu orden!</h1>
				</div>
				<div class="botones_pago">
					<div class="tpv">
						<form id="form_pagar_tpv" method="POST" action="<?php echo $this->config->item('tpv_url'); ?>">
							<input type="hidden" name="Ds_Merchant_MerchantName" value='<?php echo $Ds_Merchant_MerchantName; ?>' />
							<input type="hidden" name="Ds_Merchant_MerchantCode" value='<?php echo $Ds_Merchant_MerchantCode;?>' />
							<input type="hidden" name="Ds_Merchant_Terminal" value='<?php echo $Ds_Merchant_Terminal;?>' />
							<input type="hidden" name="Ds_Merchant_Order" value='<?php echo $Ds_Merchant_Order; ?>' />
							<input type="hidden" name="Ds_Merchant_Amount" value='<?php echo $Ds_Merchant_Amount; ?>' />
							<input type="hidden" name="Ds_Merchant_Currency" value='<?php echo $Ds_Merchant_Currency; ?>' />
							<input type="hidden" name="Ds_Merchant_TransactionType" value='<?php echo $Ds_Merchant_TransactionType; ?>' />
							<input type="hidden" name="Ds_Merchant_MerchantSignature" value='<?php echo $Ds_Merchant_MerchantSignature;?>' />
							<input type="hidden" name="Ds_Merchant_UrlOK" value="http://www.kembikio.com/index.php/tienda/aut_aceptada"/>
							<input type="hidden" name="Ds_Merchant_UrlKO" value="http://www.kembikio.com/index.php/tienda/aut_rechazada"/>
							<button class="button" onclick="alert('Serás redirigido al sistema de pagos seguros del BBVA; por favor, una vez autorizado tu pago, presiona el botón CONTINUAR para volver a nuestrio sitio web de manera segura.');">Pagar</button>
							<div class="redes_aceptadas">
								<img src="<?php echo base_url('assets/imagenes/visamaster.png'); ?>" style="width:150px"/>
							</div>						
						</form>
					</div>
					<div class="paypal">
						<h2>Pago seguro</h2>
						<h3>La transacción estará asegurada por la red Redsýs y el banco BBVA</h3>
						<img src="<?php echo base_url('assets/imagenes/redsys.png'); ?>"/>&nbsp;
						<img src="<?php echo base_url('assets/imagenes/bbva.png'); ?>"/>
						<!--<<form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_top">
							<input type="hidden" name="cmd" value="_s-xclick">
							<input type="hidden" name="hosted_button_id" value="HQU5GV87HMYVY">
							<input type="image" src="https://www.paypalobjects.com/es_ES/ES/i/btn/btn_paynowCC_LG.gif" border="0" name="submit" alt="PayPal. La forma rápida y segura de pagar en Internet.">
							<img alt="" border="0" src="https://www.paypalobjects.com/es_ES/i/scr/pixel.gif" width="1" height="1">
						</form>-->
					</div>
				</div>
		</div>
		<script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
		<script src="<?php echo base_url('assets/js/kembikio.js') ?>"></script>
	</body>
</html>