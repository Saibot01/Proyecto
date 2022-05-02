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
	<title>Lista de productos</title>
</head>
<body>
	<?php include "includes/header.php"; ?>
	<section id="container">
		
		<h1>Lista de Producto</h1>
		<a href="registro_producto.php" class="btn_new">Crear Producto</a>
		
		<form action="buscar_producto.php" method="get" class="form_search">
			<input type="text" name="busqueda" id="busqueda" placeholder="Buscar">
			<input type="submit" value="Buscar" class="btn_search">
		</form>

		<table>
			<tr>
				<th>Id</th>
				<th>Cod Barra</th>
				<th>Marca</th>
				<th>Medida</th>
				<th>Borde</th>
				<th>Sabor</th>
				<th>Precio</th>
			
			</tr>
		<?php 
			//Paginador
			$sql_registe = mysqli_query($conection,"SELECT COUNT(*) as total_registro FROM presentaciones_producto ");
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

			$query = mysqli_query($conection,"SELECT p.idProducto, p.Cod_Barra, m.Descripción as Marca, md.Descripción as Medida, b.Descripción as Borde, s.Descripción as Sabor, pr.Precio_Bruto as Precio
			FROM presentaciones_producto p
			INNER JOIN marca m ON m.idMarca = p.idMarca
			JOIN medida md ON md.idMedida = p.idMedida
			JOIN borde b ON b.idBorde = p.idBorde
			JOIN sabores s ON s.idSabor = p.idSabor
			JOIN precio pr ON pr.Cod_Barra = p.Cod_Barra
			
			
			ORDER BY idProducto ASC LIMIT $desde,$por_pagina");

			mysqli_close($conection);

			$result = mysqli_num_rows($query);
			if($result > 0){

				while ($data = mysqli_fetch_array($query)) {
					
			?>
				<tr>
					<td><?php echo $data["idProducto"]; ?></td>
					<td><?php echo $data["Cod_Barra"]; ?></td>
					<td><?php echo $data["Marca"]; ?></td>
					<td><?php echo $data["Medida"]; ?></td>
					<td><?php echo $data["Borde"]; ?></td>
					<td><?php echo $data["Sabor"]; ?></td>
					<td><?php echo $data["Precio"]; ?></td>
					
					
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
		<div class="paginador">
			<ul>
			<?php 
				if($pagina != 1)
				{
			 ?>
				<li><a href="?pagina=<?php echo 1; ?>">|<</a></li>
				<li><a href="?pagina=<?php echo $pagina-1; ?>"><<</a></li>
			<?php 
				}
				for ($i=1; $i <= $total_paginas; $i++) { 
					# code...
					if($i == $pagina)
					{
						echo '<li class="pageSelected">'.$i.'</li>';
					}else{
						echo '<li><a href="?pagina='.$i.'">'.$i.'</a></li>';
					}
				}

				if($pagina != $total_paginas)
				{
			 ?>
				<li><a href="?pagina=<?php echo $pagina + 1; ?>">>></a></li>
				<li><a href="?pagina=<?php echo $total_paginas; ?> ">>|</a></li>
			<?php } ?>
			</ul>
		</div>


	</section>
	<?php include "includes/footer.php"; ?>
</body>
</html>