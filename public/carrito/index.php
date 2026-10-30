<?php
declare(strict_types=1);

// 0. Arranque
session_start([
    'cookie_httponly' => true,
    'cookie_samesite' => 'Lax',
]);

// 1. Datos fijos
const CATEGORIAS = ['Libros', 'Ropa', 'Hogar'];

$catalogo = [
    ['id' => 1, 'nombre' => 'Novela de misterio',   'categoria' => 'Libros', 'precio' => 12.50],
    ['id' => 2, 'nombre' => 'Libro de cocina',      'categoria' => 'Libros', 'precio' => 19.90],
    ['id' => 3, 'nombre' => 'Camiseta de algodón',  'categoria' => 'Ropa',   'precio' => 15.00],
    ['id' => 4, 'nombre' => 'Sudadera con capucha', 'categoria' => 'Ropa',   'precio' => 34.95],
    ['id' => 5, 'nombre' => 'Lámpara de mesa',      'categoria' => 'Hogar',  'precio' => 22.00],
    ['id' => 6, 'nombre' => 'Juego de toallas',     'categoria' => 'Hogar',  'precio' => 27.50],
];

// 2. Funciones
function e(string $texto): string
{
    return htmlspecialchars($texto, ENT_QUOTES, 'UTF-8');
}

// 3. Recogida de datos
// (GET: qué filtro llega. POST: qué acción llega y con qué claves. COOKIE: la última categoría)
$id = (int) ($_POST['id'] ?? 0);
$categoria = $_GET['categoria'] ?? '';
$categoriaCookie = $_COOKIE['ultima_categoria'] ?? '';
$accion = $_POST['accion'] ?? '';

// 4. Validacion
if (!is_string($categoria) || !in_array($categoria, CATEGORIAS, true)) {
    $categoria = '';
}

if (!is_string($categoriaCookie) || !in_array($categoriaCookie, CATEGORIAS, true)) {
    $categoriaCookie = '';
}

// 5. Guardar
// (si es POST: añadir al carrito o vaciar, dejar mensaje flash, guardar la cookie si toca, redirigir 303)
if($_SERVER['REQUEST_METHOD'] === 'POST') {

	if($accion === 'añadir' && in_array($id, array_column($catalogo, 'id'), true)) {
		$carrito = $_SESSION['carrito'] ?? [];
		if(isset($carrito[$id])) {
			$carrito[$id]++;
		} else {
			$carrito[$id] = 1;
		}
		$_SESSION['carrito'] = $carrito;
		$_SESSION['mensaje'] = 'Añadido al carrito';
	} elseif($accion === 'vaciar') {
		$_SESSION['carrito'] = [];
		$_SESSION['mensaje'] = 'Carrito vaciado';
	}

	$destino = $_SERVER['PHP_SELF'];
    if ($categoria !== '') {
        $destino = $destino . '?categoria=' . $categoria;   // $categoria ya está validada
    }

	header('Location: ' . $destino, true, 303);
	exit;

}

if($categoria !== '') {
	setcookie('ultima_categoria', $categoria, [
		'expires'  => time() + 60 * 60 * 24 * 30,
        'path'     => '/',
        'httponly' => true,
        'samesite' => 'Lax',
	]);
}

// 6. Mostrar
// (mensaje flash, productos filtrados, líneas del carrito con subtotal, total, enlace a la última categoría)
$aviso = $_SESSION['mensaje'] ?? null;
unset($_SESSION['mensaje']);

// Filtro para mostrar la categoria elegida
$productos = [];
foreach ($catalogo as $producto) {
    if ($categoria === '' || $producto['categoria'] === $categoria) {
        $productos[] = $producto;
    }
}

$lineas = [];
$total = 0.0;
foreach ($_SESSION['carrito'] ?? [] as $idProducto => $cantidad) {
    foreach ($catalogo as $producto) {
        if ($producto['id'] === $idProducto) {
            $subtotal = $producto['precio'] * $cantidad;
            $lineas[] = ['nombre' => $producto['nombre'], 'cantidad' => $cantidad, 'precio' => $producto['precio'], 'subtotal' => $subtotal];
            $total += $subtotal;
        }
    }
}


?>
<!DOCTYPE HTML>
<!--
	Stellar by HTML5 UP
	html5up.net | @ajlkn
	Free for personal and commercial use under the CCA 3.0 license (html5up.net/license)
-->
<html lang="es">
	<head>
		<title>Tienda</title>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
		<link rel="stylesheet" href="assets/css/main.css" />
		<noscript><link rel="stylesheet" href="assets/css/noscript.css" /></noscript>
	</head>
	<body class="is-preload">

		<!-- Wrapper -->
			<div id="wrapper">

				<!-- Header -->
					<header id="header" class="alt">
						<span class="logo"><img src="images/logo.svg" alt="" /></span>
						<h1>Tienda</h1>
						<p>Elige tus productos y a&ntilde;&aacute;delos al carrito</p>
					</header>

				<!-- Nav -->
					<nav id="nav">
						<ul>
							<li><a href="#catalogo" class="active">Cat&aacute;logo</a></li>
							<li><a href="#carrito">Carrito</a></li>
						</ul>
					</nav>

				<!-- Main -->
					<div id="main">

						<!-- Cat&aacute;logo -->
							<section id="catalogo" class="main special">
								<header class="major">
									<h2>Cat&aacute;logo</h2>
								</header>

								<!-- Mensaje flash: se muestra una vez -->
								<?php if ($aviso !== null) : ?>
									<p><strong><?= e($aviso) ?></strong></p> 
								<?php endif; ?>

								<!-- Filtro por categoría (enlaces GET): "Todas" + una por categoría -->
								<ul class="actions special">

									<li><a href="?" class="button">Todas</a></li>
									<!-- una por categoría -->
									<?php foreach (CATEGORIAS as $c) : ?>
										<li>
											<a href="?categoria=<?= e($c) ?>" class="button"><?= e($c) ?></a>
										</li>
									<?php endforeach; ?>
								</ul>

								<!-- Enlace a la última categoría vista (cookie), solo si procede -->
								<?php if($categoria === '' && $categoriaCookie !== '') : ?>
									<p>Ultima categoria que viste: <a href="?categoria=<?= e($categoriaCookie) ?>" class="button"><?= e($categoriaCookie) ?></a></p>
								<?php endif; ?>

								<!-- Productos: si no hay ninguno, un aviso; si hay, uno por cada producto -->
								<?php if ($productos === []) : ?>
									<p>No hay productos</p>
								<?php else: ?>
									<ul class="features">
										<?php foreach($productos as $p) : ?>
											<li>
												<h3><?= e($p['nombre']) ?></h3>
												<p><?= e($p['categoria']) ?> -- <?= (float) $p['precio'] ?> eurs</p>
												<!-- Añadir al carrito: POST con el id del producto -->
												<form action="" method="post">
													<input type="hidden" name="accion" value="añadir" />
													<input type="hidden" name="id" value="<?=e((string) $p['id']) ?>" />
													<input type="submit" value="A&ntilde;adir" class="button small" />
												</form>
											</li>
										<?php endforeach; ?>
									</ul>
								<?php endif; ?>
							</section>

						<!-- Carrito -->
							<section id="carrito" class="main special">
								<header class="major">
									<h2>Carrito</h2>
								</header>

								<!-- Si est&aacute; vac&iacute;o: aviso. Si no: tabla con una fila por producto -->
								<div class="table-wrapper">
									<?php if ($lineas === []) : ?>
										<p>El carrito está vacío.</p>
									<?php else: ?>
										<table>
											<thead>
												<tr>
													<th>Producto</th>
													<th>Cantidad</th>
													<th>Precio</th>
													<th>Subtotal</th>
												</tr>
											</thead>
											<tbody>
												<!-- filas -->
												<?php foreach ($lineas as $linea) : ?>
													<tr>
														<td><?= e($linea['nombre'])?></td>
														<td><?= e((string)$linea['cantidad'])?></td>
														<td><?= (float) $linea['precio']?></td>
														<td><?= e((string) $linea['subtotal'])?></td>
													</tr>
												<?php endforeach; ?>	
											</tbody>
											<tfoot>
												<tr>
													<td colspan="3">Total</td>
													<td><?= e((string) $total) ?></td>
												</tr>
											</tfoot>
										</table>
									<?php endif; ?>
								</div>

								<!-- Vaciar el carrito: POST -->
								<form action="" method="post">
									<input type="hidden" name="accion" value="vaciar" />
									<input type="submit" value="Vaciar carrito" class="button" />
								</form>
							</section>

					</div>

				<!-- Footer -->
					<footer id="footer">
						<p class="copyright">&copy; Tu nombre. Design: <a href="https://html5up.net">HTML5 UP</a>.</p>
					</footer>

			</div>

		<!-- Scripts -->
			<script src="assets/js/jquery.min.js"></script>
			<script src="assets/js/jquery.scrollex.min.js"></script>
			<script src="assets/js/jquery.scrolly.min.js"></script>
			<script src="assets/js/browser.min.js"></script>
			<script src="assets/js/breakpoints.min.js"></script>
			<script src="assets/js/util.js"></script>
			<script src="assets/js/main.js"></script>

	</body>
</html>