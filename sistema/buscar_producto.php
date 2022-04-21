<?php 
	session_start();
	if($_SESSION['rol'] != 1)
	{
		header("location: ./");
	}

	include "../conexion.php";	

 ?>


<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<?php include "includes/scripts.php"; ?>
	<title>Lista de Productos</title>
</head>
<body>
	<?php include "includes/header.php"; ?>
	<section id="container">
		<?php 

			$busqueda = strtolower($_REQUEST['busqueda']);
			if(empty($busqueda))
			{
				header("location: lista_producto.php");
				mysqli_close($conection);
			}


		 ?>
		
		<h1>Lista de Productos</h1>
		<a href="registro_producto.php" class="btn_new">Crear Producto</a>
		
		<form action="buscar_producto.php" method="get" class="form_search">
			<input type="text" name="busqueda" id="busqueda" placeholder="Buscar" value="<?php echo $busqueda; ?>">
			<input type="submit" value="Buscar" class="btn_search">
		</form>

		<table>
			<tr>
				<th>Id</th>
				<th>Producto</th>
				<th>Tipo Producto</th>
				<th>Sección</th>
				<th>Subsección</th>
				<th>Categoría</th>
				<th>Activo</th>
				<th>Impuesto</th>
				<th>Observación</th>
			</tr>
		<?php 
			//Paginador

			$sql_registe = mysqli_query($conection,"SELECT COUNT(*) as total_registro FROM productos 
																WHERE ( idProducto LIKE '%$busqueda%' OR 
																		Producto LIKE '%$busqueda%'
																		)
																AND activo = 1  ");

			$result_register = mysqli_fetch_array($sql_registe);
			$total_registro = $result_register['total_registro'];

			$por_pagina = 5;

			if(empty($_GET['pagina']))
			{
				$pagina = 1;
			}else{
				$pagina = $_GET['pagina'];
			}

			$desde = ($pagina-1) * $por_pagina;
			$total_paginas = ceil($total_registro / $por_pagina);

			$query = mysqli_query($conection,"SELECT idProducto, Producto, tp.Descripción as TipoProducto, s.Descripción as Sección, sub.Descripción as Subsección, c.Descripción as Categoría, activo, observación, impuesto 
			FROM productos p  
			INNER JOIN categoria c ON c.idCategoria = p.idCategoria
			JOIN subsección sub ON	sub.idSubSección = p.idSubSección
			JOIN sección s	ON s.idSección = p.idSección
			JOIN tipoproducto tp ON tp.idTipoProducto = p.idTipoProducto 
			WHERE ( idProducto LIKE '$busqueda' OR 
					Producto LIKE '%$busqueda%') 
			AND activo = 1  
			ORDER BY idProducto ASC LIMIT $desde,$por_pagina ");
			mysqli_close($conection);
			$result = mysqli_num_rows($query);
			if($result > 0){

				while ($data = mysqli_fetch_array($query)) {
					
			?>
				<tr>
					<td><?php echo $data["idProducto"]; ?></td>
					<td><?php echo $data["Producto"]; ?></td>
					<td><?php echo $data["TipoProducto"]; ?></td>
					<td><?php echo $data["Sección"]; ?></td>
					<td><?php echo $data["Subsección"]; ?></td>
					<td><?php echo $data["Categoría"]; ?></td>
					<td><?php echo $data["activo"]; ?></td>
					<td><?php echo $data["impuesto"]; ?></td>
					<td><?php echo $data["observación"]; ?></td>
					<td>
						<a class="link_edit" href="editar_producto.php?id=<?php echo $data["idProducto"]; ?>">Editar</a>
						<a class="link_delete" href="eliminar_confirmar_producto.php?id=<?php echo $data["idProducto"]; ?>">Eliminar</a>
						
					</td>
				</tr>
			
		<?php 
				}

			}
		 ?>


		</table>
<?php 
	
	if($total_registro != 0)
	{
 ?>
		<div class="paginador">
			<ul>
			<?php 
				if($pagina != 1)
				{
			 ?>
				<li><a href="?pagina=<?php echo 1; ?>&busqueda=<?php echo $busqueda; ?>">|<</a></li>
				<li><a href="?pagina=<?php echo $pagina-1; ?>&busqueda=<?php echo $busqueda; ?>"><<</a></li>
			<?php 
				}
				for ($i=1; $i <= $total_paginas; $i++) { 
					# code...
					if($i == $pagina)
					{
						echo '<li class="pageSelected">'.$i.'</li>';
					}else{
						echo '<li><a href="?pagina='.$i.'&busqueda='.$busqueda.'">'.$i.'</a></li>';
					}
				}

				if($pagina != $total_paginas)
				{
			 ?>
				<li><a href="?pagina=<?php echo $pagina + 1; ?>&busqueda=<?php echo $busqueda; ?>">>></a></li>
				<li><a href="?pagina=<?php echo $total_paginas; ?>&busqueda=<?php echo $busqueda; ?> ">>|</a></li>
			<?php } ?>
			</ul>
		</div>
<?php } ?>

		
		
		

	</section>
	<?php include "includes/footer.php"; ?>
</body>
</html>
