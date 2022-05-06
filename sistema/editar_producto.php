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
		empty($_POST['cbx_idBorde']) || empty($_POST['cbx_idSabor']) || empty($_POST['Precio_Bruto']) || empty($_POST['pobservación']) )		{
			$alert='<p class="msg_error">Todos los campos son obligatorios.</p>';
		}else{
			
			$idproducto = $_POST['idProducto'];
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
			$precio_bruto = $_POST['Precio_Bruto'];
			$pobservación = $_POST['pobservación'];


			/*$query = mysqli_query($conection,"SELECT * FROM productos 
													   WHERE (Producto = '$producto')");
			$result = mysqli_fetch_array($query);
			if($result > 0){
				$alert='<p class="msg_error">Producto ya existe.</p>';
			}else{*/

				if(empty($_POST['id']))
				{

					$sql_update_producto = mysqli_query($conection,"UPDATE productos
															SET Producto = '$producto', idTipoProducto='$idtipoproducto',idSección='$idseccion',idSubsección='$idsubseccion', idCategoria= '$idcategoria', activo= '$activo', impuesto= '$impuesto', observación = '$observacion' 
										/*Revisar*/			WHERE idProducto= $idproducto ");
				}

				if($sql_update_producto){
					$alert='<p class="msg_save">Producto actualizado correctamente.</p>';
				}else{
					$alert='<p class="msg_error">Error al actualizar el Producto.</p>';
				}

				if(empty($_POST['id']))
				{

					$sql_update_presentacion = mysqli_query($conection,"UPDATE presentaciones_producto 
					SET idMarca = '$idMarca', idMedida= '$idMedida', idBorde= '$idBorde', idSabor= '$idSabor
					WHERE Cod_Barra= $Cod_Barra");
										
				}

				if($sql_update_presentacion){
					$alert='<p class="msg_save">Presentaciones Producto actualizado correctamente.</p>';
				}else{
					$alert='<p class="msg_error">Error al actualizar el Presentaciones Producto.</p>';
				}
				if(empty($_POST['id']))
				{

					$sql_update_precio = mysqli_query($conection,"UPDATE precio
					SET  Precio_Bruto = '$precio_bruto', Observación = '$pobservación' 
					WHERE Cod_Barra= $Cod_Barra");
										
				}

				if($sql_update_precio){
					$alert='<p class="msg_save">Precio actualizado correctamente.</p>';
				}else{
					$alert='<p class="msg_error">Error al actualizar el Precio.</p>';
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

	$sql= mysqli_query($conection,"SELECT p.idProducto, p.Producto, pro.Cod_Barra, tp.Descripción AS TipoProducto,
	s.Descripción AS Sección, sub.Descripción AS Subsección, c.Descripción AS Categoría,
	 activo, p.observación, impuesto,m.Descripción AS Marca, md.Descripción AS Medida,
	  b.Descripción AS Borde, s.Descripción AS Sabor, pr.Precio_Bruto AS Precio, pr.Observación AS pObservación 
			   FROM productos p  
			   INNER JOIN categoria c ON c.idCategoria = p.idCategoria
			   JOIN subsección sub ON	sub.idSubSección = p.idSubSección
			   JOIN sección se	ON se.idSección = p.idSección
			   JOIN tipoproducto tp ON tp.idTipoProducto = p.idTipoProducto
			   JOIN presentaciones_producto pro ON pro.idProducto = p.idProducto
			   JOIN marca m ON m.idMarca = pro.idMarca
			   JOIN medida md ON md.idMedida = pro.idMedida
			   JOIN borde b ON b.idBorde = pro.idBorde
			   JOIN sabores s ON s.idSabor = pro.idSabor
			   JOIN precio pr ON pr.Cod_Barra = pro.Cod_Barra
	WHERE p.idProducto= $idproducto ");
	mysqli_close($conection);
	$result_sql = mysqli_num_rows($sql);

	if($result_sql == 0){
		header('Location: lista_producto.php');
	}else{
		$option = '';
		while ($data = mysqli_fetch_array($sql)) {
			# code...
			$producto = $data['Producto'];
			$Cod_Barra = $data['Cod_Barra'];
			$idtipoproducto  = $data['TipoProducto'];
			$idseccion   = $data['Sección'];
			$idsubseccion  = $data['Subsección'];
			$idcategoria    = $data['Categoría'];
			$activo    = $data['activo'];
			$observacion    = $data['observación'];
			$impuesto    = $data['impuesto'];
			$idMarca   = $data['Marca'];
			$idMedida	= $data['Medida'];
			$idBorde   = $data['Borde'];
			$idSabor   = $data['Sabor'];
			$precio_bruto = $data['Precio'];
			$pobservación = $data['pObservación'];

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

				<input type="text" name="Producto" id="Producto" placeholder="Nombre Productocompleto" value="<?php echo $producto; ?>">

				<label for="Cod_Barra">Cod_Barra</label>
				<input type="text" name="Cod_Barra" id="Cod_Barra" placeholder="Ingrese el codigo de barra correspondiente"value="<?php echo $Cod_Barra; ?>">

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

				<option value="0"> <?php echo $idtipoproducto; ?> </option>

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

				<input type="text" name="activo" id="activo" placeholder="activo"value="<?php echo $activo; ?> ">

				<label for="impuesto">Impuesto</label>
				<input type="text" name="impuesto" id="impuesto" placeholder="Inserte impuesto"value="<?php echo $impuesto; ?>">

				<label for="observacion">Observacion</label>
				<input type="text" name="observacion" id="observacion" placeholder="Inserte Observación" value="<?php echo $observacion; ?>">
				

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
				
				<label for="Precio_Bruto">Precio</label>
				<input type="text" name="Precio_Bruto" id="Precio_Bruto" placeholder="Precio Producto" value="<?php echo $precio_bruto; ?>">

				<label for="pobservación">Observación</label>
				<input type="text" name="pobservación" id="pobservación" placeholder="Observación Precio" value="<?php echo $pobservación; ?>">


				<input type="submit" value="Registrar nuevo producto" class="btn_save">

			</form>


		</div>


	</section>
	<?php include "includes/footer.php"; ?>
</body>
</html>