<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>Inicio</title>
	<link rel="stylesheet" href="css/estilo_principal.css">
</head>
<body>
	<div class="form-login">
		<form action="?clase=session" method="post" accept-charset="utf-8">
			<p>Formulario de acceso</p>
			<input type="text" name="id" placeholder="ID Admin">
			<input type="password" name="contrasenia" placeholder="Contraseña">
			<div class="layout-btns">
        <input type="submit" value="Iniciar sesion" />
        <a href="?clase=administradorController">Recuperar usuario</a>
			<div>
		</form>
	</div>
</body>
</html>
