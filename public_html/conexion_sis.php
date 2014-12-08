<?php
	//----------------------------------------
	// URL del TPV Virtual. Depende del entorno.
	//----------------------------------------
   $URL_TPVVIRTUAL 	= " https://sis-t.redsys.es:25443/sis/realizarPago";

 	//-----------------------------------------
	// PARAMETROS A DEFINIR EN ESTA PAGINA NO DEBEN SER VISIBLES PARA EL USUARIO
	// SI MIRA EL CODIGO FUENTE HTML, SOBRE TODO EL PASSWORD
	// Se mapean con datos reales.	
	//-----------------------------------------
	$Merchant_Code			= "332875228";
	$Merchant_Terminal	= "1";
	$Merchant_Password	= "qwertyasdf0123456789";
 	$Merchant_Currency  	= "978"; 	
 	$Merchant_Name   		= "KEMBIKIO";
 	$tipoFirma   			= "21";

	//----------------------------------------
	// PARAMETROS DE LA COMPRA RECIBIDOS. El pedido es optativo.
	//----------------------------------------
	// Comprobamos si hemos recibido algun formulario con datos
	if (!$_POST) {
 		out.print("<RETORNOXML><CODIGO>SIS0000</CODIGO></RETORNOXML>");
 		return;
	}
	 	
 	$Merchant_Order 				= $_POST["Ds_Merchant_Order"];
 	// Si no viene el numero de pedido lo generamos nosotros
 	if ($Merchant_Order == null || $Merchant_Order.equals("")) { 		
		//$formador = new SimpleDateFormat("yyMMddHHmmss");
		//$Merchant_Order = formador.format(new Date());
		$Merchant_Order = time();
		//Merchant_Order = valor++;
 	}
 	$Merchant_Amount     		= $_POST["Ds_Merchant_Amount"];
 	$Merchant_SumTotal		   = $_POST["Ds_Merchant_SumTotal"];
 	$Merchant_DateFrecuency		= $_POST["Ds_Merchant_DateFrecuency"];
 	$Merchant_ChargeExpiryDate = $_POST["Ds_Merchant_ChargeExpiryDate"];
 	$Merchant_TransactionType	= $_POST["Ds_Merchant_TransactionType"];
 	$Merchant_MerchantURL		= $_POST["Ds_Merchant_MerchantURL"];
 	$Entorno		 					= $_POST["Ds_Merchant_Entorno"];
 	// Comprobamos que está apuntando a donde quiere
 	if ($Entorno == null || $Entorno == "") {
 		out.print("<RETORNOXML><CODIGO>SIS0001</CODIGO></RETORNOXML>");
 		return;
 	}
 	if ($Entorno != null && $Entorno == "PRUEBAS" && $URL_TPVVIRTUAL != " https://sis-t.redsys.es:25443/sis/realizarPago") {
 		out.print("<RETORNOXML><CODIGO>SIS0002</CODIGO></RETORNOXML>");
 		return;
 	}
 	if ($Entorno != null && $Entorno == "INTEGRACION" && $URL_TPVVIRTUAL != "https://sis-i.sermepa.es:25443/sis/realizarPago") {
	 	out.print("<RETORNOXML><CODIGO>SIS0003</CODIGO></RETORNOXML>");
 		return;
 	}
 	if ($Entorno != null && $Entorno == "PRODUCCION" && $URL_TPVVIRTUAL != "https://sis.sermepa.es/sis/realizarPago") {
	 	out.print("<RETORNOXML><CODIGO>SIS0004</CODIGO></RETORNOXML>");
 		return;
 	}

	// Campos de la firma
	$firma = $Merchant_Amount . $Merchant_Order . $Merchant_Code . $Merchant_Currency;
	if ($Merchant_TransactionType == "0" || $Merchant_TransactionType == "R") {
		// Se añade la suma total
		$firma = $firma . $Merchant_SumTotal;
	}
	if ($tipoFirma == "21") {
		// Si es completo ampliado se añaden el tipo y la url
		$firma = $firma . $Merchant_TransactionType . $Merchant_MerchantURL;		
	}
	$firma = sha1($firma . $Merchant_Password);


echo "<html><head><script language='JavaScript'>function enviar() {document.compra.submit();}</script>
</head>
	<body bgcolor=white onLoad='javascript:enviar();'>

		<form name=compra action=$URL_TPVVIRTUAL method=post>
	      <input type=hidden name=Ds_Merchant_MerchantName value='$Merchant_Name' />
			<input type=hidden name=Ds_Merchant_MerchantCode value='$Merchant_Code' />
			<input type=hidden name=Ds_Merchant_Terminal value='$Merchant_Terminal' />
			<input type=hidden name=Ds_Merchant_Order value='$Merchant_Order' />
			<input type=hidden name=Ds_Merchant_Amount value='$Merchant_Amount' />
			<input type=hidden name=Ds_Merchant_SumTotal value='$Merchant_SumTotal' />
			<input type=hidden name=Ds_Merchant_DateFrecuency value='$Merchant_DateFrecuency' />
			<input type=hidden name=Ds_Merchant_ChargeExpiryDate value='$Merchant_ChargeExpiryDate' />
			<input type=hidden name=Ds_Merchant_Currency value='$Merchant_Currency' />
			<input type=hidden name=Ds_Merchant_TransactionType value='$Merchant_TransactionType' />
			<input type=hidden name=Ds_Merchant_MerchantURL value='$Merchant_MerchantURL' />
			<input type=hidden name=Ds_Merchant_MerchantSignature value='$firma' />
			<NOSCRIPT>
				<input type=submit name=Aceptar value='Aceptar' />
			<NOSCRIPT>
	    </form> 

	</body>
</html>
";
?>
