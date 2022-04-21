<?php 
	
	session_start();
	if($_SESSION['rol'] != 1)
	{
		header("location: ./");
	}

	include "../conexion.php";

	if(!empty($_POST))
	{
		$alert='';
		if(empty($_POST['Producto']) || empty($_POST['idTipoProducto']) || empty($_POST['idSección']) || empty($_POST['idSubsección']) || empty($_POST['idCategoria']) || empty($_POST['activo']) || empty($_POST['impuesto']) || empty($_POST['observacion']))
		{
			$alert='<p class="msg_error">Todos los campos son obligatorios.</p>';
		}else{
			$idproducto = $_POST['idProducto'];
			$producto = $_POST['Producto'];
			$idtipoproducto  = $_POST['idTipoProducto'];
			$idseccion   = $_POST['idSección'];
			$idsubseccion  = $_POST['idSubsección'];
			$idcategoria    = $_POST['idCategoria'];
			$activo    = $_POST['activo'];
			$observacion    = $_POST['observacion'];
			$impuesto    = $_POST['impuesto'];


			/*$query = mysqli_query($conection,"SELECT * FROM productos 
													   WHERE (Producto = '$producto')");

			$result = mysqli_fetch_array($query);

			if($result > 0){
				$alert='<p class="msg_error">Producto ya existe.</p>';
			}else{*/

				if(empty($_POST['id']))
				{

					$sql_update = mysqli_query($conection,"UPDATE productos
															SET Producto = '$producto', idTipoProducto='$idtipoproducto',idSección='$idseccion',idSubsección='$idsubseccion', idCategoria= '$idcategoria', activo= '$activo', impuesto= '$impuesto', observación = '$observacion' 
										/*Revisar*/			WHERE idProducto= $idproducto ");
				}

				if($sql_update){
					$alert='<p class="msg_save">Producto actualizado correctamente.</p>';
				}else{
					$alert='<p class="msg_error">Error al actualizar el Producto.</p>';
				}

			}


		}

	//}

	//Mostrar Datos
	if(empty($_REQUEST['id']))
	{
		header('Location: lista_producto.php');
		mysqli_close($conection);
	}
	$idproducto = $_REQUEST['id'];

	$sql= mysqli_query($conection,"SELECT *
									FROM productos
									WHERE idProducto= $idproducto ");
	mysqli_close($conection);
	$result_sql = mysqli_num_rows($sql);

	if($result_sql == 0){
		header('Location: lista_producto.php');
	}else{
		$option = '';
		while ($data = mysqli_fetch_array($sql)) {
			# code...
			$producto = $data['Producto'];
			$idtipoproducto  = $data['idTipoProducto'];
			$idseccion   = $data['idSección'];
			$idsubseccion  = $data['idSubsección'];
			$idcategoria    = $data['idCategoria'];
			$activo    = $data['activo'];
			$observacion    = $data['observación'];
			$impuesto    = $data['impuesto'];

			/*if($idrol == 1){
				$option = '<option value="'.$idrol.'" select>'.$rol.'</option>';
			}else if($idrol == 2){
				$option = '<option value="'.$idrol.'" select>'.$rol.'</option>';	
			}else if($idrol == 3){
				$option = '<option value="'.$idrol.'" select>'.$rol.'</option>';
			}*/


		}
	}

 ?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<?php include "includes/scripts.php"; ?>
	<title>Actualizar Usuario</title>
</head>
<body>
	<?php include "includes/header.php"; ?>
	<section id="container">
		
		<div class="form_register">
			<h1>Actualizar Producto</h1>
			<hr>
			<div class="alert"><?php echo isset($alert) ? $alert : ''; ?></div>
			
			<form action="" method="post">
			<input type="hidden" name="idProducto" value="<?php echo $idproducto; ?>">
			<label for="Producto">Producto</label>
				<input type="text" name="Producto" id="Producto" placeholder="Nombre Productocompleto" value="<?php echo $producto; ?>"> 

				<label for="idTipoProducto">idTipoProducto</label>
				<input type="text" name="idTipoProducto" id="idTipoProducto" placeholder="idTipoProducto" value="<?php echo $idtipoproducto; ?>">

				<label for="idSección">idSección</label>
				<input type="text" name="idSección" id="idSección" placeholder="id Sección" value="<?php echo $idseccion; ?>">

				<label for="IdSubsección">idSubsección</label>
				<input type="text" name="idSubsección" id="idSubsección" placeholder="idSubsección" value="<?php echo $idsubseccion; ?>">

				<label for="idCategoria">idCategoria</label>
				<?php 
					include "../conexion.php";
					$query_cat = mysqli_query($conection,"SELECT * FROM categoria");
					mysqli_close($conection);
					$result_cat = mysqli_num_rows($query_cat);

				 ?>

				<select name="idCategoria" id="idCategoria"class="notItemOne">
					<?php 
						if($result_cat > 0)
						{
							while ($idcategoria = mysqli_fetch_array($query_cat)) {
					?>
							<option value="<?php echo $idcategoria["idCategoria"]; ?>"><?php echo $idcategoria["Descripción"] ?></option>
					<?php 
								# code...
							}
							
						}
					 ?>
				</select>

				<label for="activo">activo</label>
				<input type="text" name="activo" id="activo" placeholder="activo"value="<?php echo $activo; ?>">

				<label for="impuesto">impuesto</label>
				<input type="text" name="impuesto" id="impuesto" placeholder="Inserte impuesto"value="<?php echo $impuesto; ?>">

				<label for="observacion">observacion</label>
				<input type="text" name="observacion" id="observacion" placeholder="Inserte Observación"value="<?php echo $observacion; ?>">
				<input type="submit" value="Actualizar Producto" class="btn_save">

			</form>


		</div>


	</section>
	<?php include "includes/footer.php"; ?>
</body>
</html>