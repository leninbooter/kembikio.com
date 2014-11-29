<h1 class="titulo">Contáctanos</h1>
<div class="fila_contactos">
	<div class="columna_izq">
		<p class="email">info@kembikio.com</p>
		<p class="telefono">+34 645 22 70 23</p>
		<p class="centrado direccion">Calle Conde de Peñalver, 82<br/>Madrid, 28006<br/>España<br/></p>
		<iframe src="https://mapsengine.google.com/map/u/0/embed?mid=zyV2mZ9QPSBc.kKJRohh_C5QQ" width="450" height="340"></iframe>
	</div>
	<div id="div_form_contacto" class="columna_der">		
		<form id="form_contacto">			
			<fieldset>
				<legend>Escríbenos</legend>
				<div class="fila_campos"><label>Asunto:<span class="requerido">*</span></label><select id="asunto" name="asunto" required class="bordenormal">
						<option value=""></option>
						<option value="Preguntas acerca de Kembikio">Preguntas acerca de Kembikio</option>
						<option value="Planes y precios">Planes y precios</option>
						<option value="Sugerencias sobre la web">Sugerencias sobre la web</option>
						<option value="Otro">Otro</option>
					</select>
				</div>
				<div class="fila_campos"><label>Nombre:<span class="requerido">*</span></label><input type="text" id="nombre" name="nombre" required maxlength="50" class="bordenormal"></div>
				<div class="fila_campos"><label>Apellido:<span class="requerido">*</span></label><input type="text" id="apellido" name="apellido" required maxlength="50" class="bordenormal"></div>
				<div class="fila_campos"><label>E-mail:<span class="requerido">*</span></label><input type="text" id="email" name="email" required maxlength="200" class="bordenormal"></div>
				<div class="fila_campos"><label>Teléfono:<span class="requerido">*</span></label><input type="text" id="telefono" name="telefono" required maxlength="20" class="bordenormal"></div>
				<div class="fila_campos"><label>Compañía: </label><input type="text" id="empresa" name="empresa" maxlength="200" class="bordenormal"></div><div class="fila_campos"><label>Cargo: </label><input type="text" id="cargo" name="cargo" maxlength="200" class="bordenormal"/></div>
				<div class="fila_campos"><label>Comentarios:<span class="requerido">*</span></label><textarea id="comentarios" name="comentarios" required class="bordenormal"></textarea></div>
				<div class="fila_campos"><label>&nbsp;</label><div id="respuesta_form_contacto"></div></div>
				<button>Enviar</button>
			</fieldset>
			
		</form>
	</div>
</div>