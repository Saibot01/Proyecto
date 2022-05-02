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
		if(empty($_POST['Producto']) || empty($_POST['Cod_Barra']) || empty($_POST['cbx_tipoProducto']) || empty($_POST['cbx_seccion']) ||
		empty($_POST['cbx_subseccion']) || empty($_POST['idCategoria']) || empty($_POST['activo']) ||
		empty($_POST['impuesto']) || empty($_POST['observacion']) || empty($_POST['cbx_idMarca']) || empty($_POST['cbx_idMedida']) || 
		empty($_POST['cbx_idBorde'])|| empty($_POST['cbx_idSabor']))		{
			$alert='<p class="msg_error">Todos los campos son obligatorios.</p>';
		}else{
			
			$producto = $_POST['Producto'];
			$Cod_Barra = $_POST['Cod_Barra'];
			$idtipoproducto  = $_POST['cbx_tipoProducto'];
			$idseccion   = $_POST['cbx_seccion'];
			$idsubseccion  = $_POST['cbx_subseccion'];
			$idcategoria    = $_POST['idCategoria'];
			$activo    = $_POST['activo'];
			$observacion    = $_POST['observacion'];
			$impuesto    = $_POST['impuesto'];
			$idMarca   = $_POST['cbx_idMarca'];
			$idMedida	= $_POST['cbx_idMedida'];
			$idBorde   = $_POST['cbx_idBorde'];
			$idSabor   = $_POST['cbx_idSabor'];


			//$query = mysqli_query($conection,"SELECT * FROM productos WHERE usuario = '$user' OR correo = '$email' ");
			//$result = mysqli_fetch_array($query);

			//if($result > 0){
			//	$alert='<p class="msg_error">El correo o el usuario ya existe.</p>';
			//}else{

				$query_insert_product = mysqli_query($conection,"INSERT INTO productos (Producto, idTipoProducto, idSección, idSubsección, idCategoria, activo, observación, impuesto) 
				VALUES ('$producto','$idtipoproducto','$idseccion','$idsubseccion','$idcategoria','$activo','$observacion','$impuesto')");
				if($query_insert_product){
					$alert='<p class="msg_save"> tabla Producto insertada correctamente.</p>';
				}else{
					$alert='<p class="msg_error">Error al crear el Producto.</p>';
				}

				$query_insert_presentacion = mysqli_query($conection,"INSERT INTO presentaciones_producto (idProducto, Cod_Barra, idMarca, idMedida, idBorde, idSabor) 
				VALUES ((SELECT max(idproducto) FROM productos),'$Cod_Barra','$idMarca','$idMedida','$idBorde','$idSabor')");
				if($query_insert_presentacion){
					$alert='<p class="msg_save">Tabla presentacion insertada correctamente.</p>';
				}else{
					$alert='<p class="msg_error">Error al insertar correctamente presentacion</p>';
				}
			//}


		}

	}



 ?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<?php include "includes/scripts.php"; ?>
	<title>Registro Producto</title>
</head>
<body>
	<?php include "includes/header.php"; ?>
	<section id="container">
		
		<div class="form_register">
			<h1>Registro Producto</h1>
			<hr>
			<div class="alert"><?php echo isset($alert) ? $alert : ''; ?></div>

			<form action="" method="post">


				<label for="Producto">Producto</label>
				<input type="text" name="Producto" id="Producto" placeholder="Nombre Productocompleto">

				<label for="Cod_Barra">Cod_Barra</label>
				<input type="text" name="Cod_Barra" id="Cod_Barra" placeholder="Ingrese el codigo de barra correspondiente">

				<?php
					require ('../conexion.php');
					$querysec = "SELECT * FROM tipoproducto";
					$resultadosec=$conection->query($querysec);
				?>

				<label for="cbx_tipoProducto">Tipo Producto</label>
					<select name="cbx_tipoProducto" id="cbx_tipoProducto">
				<option value="0">Seleccionar Tipo Producto</option>
				<?php while($rowsec = $resultadosec->fetch_assoc()) { ?>
					<option value="<?php echo $rowsec['idTipoProducto']; ?>"><?php echo $rowsec['Descripción']; ?></option>

				<?php }	
					 ?>

				</select>
				
				<?php
					require ('../conexion.php');
					$querysec = "SELECT idsección, Descripción FROM sección";
					$resultadosec=$conection->query($querysec);
				?>

				<label for="cbx_seccion">Sección : </label>
					<select name="cbx_seccion" id="cbx_seccion">
				<option value="0">Seleccionar Sección</option>
				<?php while($rowsec = $resultadosec->fetch_assoc()) { ?>
					<option value="<?php echo $rowsec['idsección']; ?>"><?php echo $rowsec['Descripción']; ?></option>

				<?php }	
					 ?>

				</select>
				<?php
					require ('../conexion.php');
					$query = "SELECT idSubsección, Descripción FROM subsección";
					$resultado=$conection->query($query);
				?>

				<label for="cbx_subseccion">Subseccion : </label>
				<select name="cbx_subseccion" id="cbx_subseccion">
				<option value="0">Seleccionar Subsección</option>
				<?php while($row = $resultado->fetch_assoc()) { ?>
					<option value="<?php echo $row['idSubsección']; ?>"><?php echo $row['Descripción']; ?></option>
				
					<?php } ?>
				</select>

				<label for="idCategoria">Categoria</label>
				
				<?php 

					$query_cat = mysqli_query($conection,"SELECT * FROM categoria");
					mysqli_close($conection);
					$result_cat = mysqli_num_rows($query_cat);

				 ?>

				<select name="idCategoria" id="idCategoria">
				<option value="0">Seleccionar Categoria</option>
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

				<label for="activo">Activo</label>
				<input type="text" name="activo" id="activo" placeholder="activo">

				<label for="impuesto">Impuesto</label>
				<input type="text" name="impuesto" id="impuesto" placeholder="Inserte impuesto">

				<label for="observacion">Observacion</label>
				<input type="text" name="observacion" id="observacion" placeholder="Inserte Observación">
				

				<?php
					require ('../conexion.php');
					$query = "SELECT idMarca, Descripción FROM Marca";
					$resultado=$conection->query($query);
				?>

				<label for="cbx_idMarca">Marca</label>
				<select name="cbx_idMarca" id="cbx_idMarca">
				<option value="0">Seleccionar Marca</option>
				<?php while($row = $resultado->fetch_assoc()) { ?>
					<option value="<?php echo $row['idMarca']; ?>"><?php echo $row['Descripción']; ?></option>
				
					<?php } ?>
				</select>
				
				<?php
					require ('../conexion.php');
					$query = "SELECT idMedida, Descripción FROM Medida";
					$resultado=$conection->query($query);
				?>
				
				<label for="cbx_idMedida">Medida</label>
				<select name="cbx_idMedida" id="cbx_idMedida">
				<option value="0">Seleccionar Medida</option>
				<?php while($row = $resultado->fetch_assoc()) { ?>
					<option value="<?php echo $row['idMedida']; ?>"><?php echo $row['Descripción']; ?></option>
				
					<?php } ?>
				</select>

				<?php
					require ('../conexion.php');
					$query = "SELECT idBorde, Descripción FROM borde";
					$resultado=$conection->query($query);
				?>
				
				<label for="cbx_idBorde">Medida</label>
				<select name="cbx_idBorde" id="cbx_idBorde">
				<option value="0">Seleccionar Borde</option>
				<?php while($row = $resultado->fetch_assoc()) { ?>
					<option value="<?php echo $row['idBorde']; ?>"><?php echo $row['Descripción']; ?></option>
				
					<?php } ?>
				</select>


				<?php
					require ('../conexion.php');
					$query = "SELECT idSabor, Descripción FROM Sabores";
					$resultado=$conection->query($query);
				?>
				<label for="cbx_idSabor">Sabores</label>
				<select name="cbx_idSabor" id="cbx_idSabor">
				<option value="0">Seleccionar Sabor</option>
				<?php while($row = $resultado->fetch_assoc()) { ?>
					<option value="<?php echo $row['idSabor']; ?>"><?php echo $row['Descripción']; ?></option>
				
					<?php } ?>
				</select> 
				
				<input type="submit" value="Registrar nuevo producto" class="btn_save">

			</form>

		</div>

	</section>
	<?php include "includes/footer.php"; ?>
</body>
</html>