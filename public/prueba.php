<?php
	$linea = fgets(STDIN);
	$datos = explode(" ", trim($linea));


	$palabra = array_shift($datos);

	$letras = array_slice($datos, 0, count($datos));
		
	// Descomponer datos con for para asginar valores al array de letras
	// $datos ya tiene las letras, no hay que descomoner nada?
	// Validar con $datos un if y un condicional para validar > 5 letras

	$resultado = '';
	$aciertos = 0;


	for($i = 0; $i < strlen($palabra); $i++){

		$letra = $palabra[$i];

		if(in_array($letra, $letras)){
			$resultado .= $letra . " ";
			$aciertos++;
		} else{
			$resultado .= '_ ';
		}
	}

	// depuracion
	//echo var_dump($datos);
	//echo "\n";
	//echo var_dump($letras);
	//echo "\n";
	echo 'Has acertado ' . $aciertos . ' letras.';
	echo "\n";
	echo 'La palabra a buscar ha quedado ' . $resultado . '.';