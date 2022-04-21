<?php 
	session_start();
	if($_SESSION['rol'] != 1)
	{
		header("location: ./");
	}
	include "../conexion.php";

	if(!empty($_POST))
	{
		if($_POST['idProducto'] == 1){
			header("location: lista_producto.php");
			mysqli_close($conection);
			exit;
		}
		$idproducto = $_POST['idProducto'];

		$query_delete = mysqli_query($conection,"DELETE FROM productos WHERE idproducto =$idproducto ");
		/*$query_delete = mysqli_query($conection,"UPDATE productos SET activo = 0 WHERE idProducto = $idproducto ");*/
		mysqli_close($conection);
		if($query_delete){
			header("location: lista_producto.php");
		}else{
			echo "Error al eliminar";
		}

	}




	if(empty($_REQUEST['id']) || $_REQUEST['id'] == 1 )
	{
		header("location: lista_producto.php");
		mysqli_close($conection);
	}else{

		$idproducto = $_REQUEST['id'];

		$query = mysqli_query($conection,"SELECT idProducto, Producto, tp.Descripción as TipoProducto, s.Descripción as Sección, sub.Descripción as Subsección, c.Descripción as Categoría, activo, observación, impuesto 
		FROM productos p  
		INNER JOIN categoria c ON c.idCategoria = p.idCategoria
		JOIN subsección sub ON	sub.idSubSección = p.idSubSección
		JOIN sección s	ON s.idSección = p.idSección
		JOIN tipoproducto tp ON tp.idTipoProducto = p.idTipoProducto 
		WHERE idProducto = $idproducto ");
		
		mysqli_close($conection);
		$result = mysqli_num_rows($query);

		if($result > 0){
			while ($data = mysqli_fetch_array($query)) {
				# code...
			$producto = $data['Producto'];
			
			$activo    = $data['activo'];
			$observacion    = $data['observación'];
			$impuesto    = $data['impuesto'];
			}
		}else{
			header("location: lista_producto.php");
		}


	}


 ?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<?php include "includes/scripts.php"; ?>
	<title>Eliminar Producto</title>
</head>
<body>
	<?php include "includes/header.php"; ?>
	<section id="container">
		<div class="data_delete">
			<h2>¿Está seguro de eliminar el siguiente registro?</h2>
			<p>Producto: <span><?php echo $producto; ?></span></p>
			<p>Observación: <span><?php echo $observacion; ?></span></p>
			<p>Activo: <span><?php echo $activo; ?></span></p>

			<form method="post" action="">
				<input type="hidden" name="idProducto" value="<?php echo $idproducto; ?>">
				<a href="lista_producto.php" class="btn_cancel">Cancelar</a>
				<input type="submit" value="Aceptar" class="btn_ok">
			</form>
		</div>


	</section>
	<?php include "includes/footer.php"; ?>
</body>
</html>