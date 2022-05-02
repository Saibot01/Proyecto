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
				
				<label for="cbx_idBorde">Borde</label>
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