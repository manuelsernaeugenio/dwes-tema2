<?php

$frases = [
    "IES La Encanta",
    "La vida de Brian",
    "Java es divertido",
    "Matrix es una gran pelicula",
    "Ojo con el ajo",
    "Pirineos y Alpes",
    "Comunidad Valenciana",
    "Informatica es CS en ingles",
    "Africa y Europa",
    "Asia y America",
    "Chincheta",
    "Frigorifico",
    "Chimenea",
    "Rojales",
    "Rio Segura"
];
/* $frases = [
    "hola",
    "hola que tal"
]; */

// Declaramos la variable que indica si ha ganado o no.
$ganador = false;

// Elegimos aleatoriamente una frase del array.
$random = rand(0, count($frases) - 1);
$fraseRandom = $frases[$random];

// Pasamos la frase a minúsculas.
$fraseRandom = mb_strtolower($fraseRandom, "UTF-8");

// Quitamos los acentos de la frase.
$buscar = ["á", "é", "í", "ó", "ú"];
$reemplazar = ["a", "e", "i", "o", "u"];

$fraseRandom = str_replace($buscar, $reemplazar, $fraseRandom, $cambios);

// Convertimos la frase array y obtenemos las letras.
$arrayFraseRandom = mb_str_split($fraseRandom, 1, "UTF-8");

// Reemplazamos los espacios por nulos ya que no cuentan como letras para luego hacer el checkeo.
$arrayFraseRandom = array_replace(
    $arrayFraseRandom,
    array_fill_keys(
        array_keys($arrayFraseRandom, " "),
        null
    )
);

// Eliminamos los nulos.
$arrayFraseRandom = array_filter($arrayFraseRandom);

// Fallos realizados por el usuario.
$fallos = 0;

// Letras acertadas por el usuario. (lo usaremos luego para comprobar si ha adivinado la frase entera)
// Estas letras, tienen un filtro primero antes de ser añadidas.
$letrasAcertadas = 0;

// Este array lo formará el usuario con las letras que haya adivinado.
$fraseUsuario = array();

for ($i = 0; $i <= strlen($fraseRandom); $i++) {
    $fraseUsuario[$i] = $i;
}

// Función que indica según los fallos, el estado de la partida.
function checkInfo()
{
    global $fallos, $fraseRandom, $fraseUsuario;

    switch ($fallos) {
        case 0:
            echo <<<_END
                ____
                |    |
                |    
                |   
                |   
                |
            ---\n
            _END;
            break;
        case 1:
            echo <<<_END
                ____
                |    |
                |    O
                |   
                |   
                |
            ---\n
            _END;
            break;
        case 2:
            echo <<<_END
                ____
                |    |
                |    O
                |    |
                |   
                |
            ---\n
            _END;
            break;
        case 3:
            echo <<<_END
                ____
                |    |
                |    O
                |   /|
                |   
                |
            ---\n
            _END;
            break;
        case 4:
            echo <<<_END
                ____
                |    |
                |    O
                |   /|\
                |   
                |
            ---\n
            _END;
            break;
        case 5:
            echo <<<_END
                ____
                |    |
                |    O
                |   /|\
                |   / 
                |
            ---\n
            _END;
            break;
        case 6:
            echo <<<_END
                ____
                |    |
                |    O
                |   /|\
                |   / \
                |
            ---\n
            _END;
            break;
    }

    $frase = mb_str_split($fraseRandom, 1, "UTF-8");

    // echo "$fraseRandom \n";
    // echo count($frase) . "\n";
    // Printea en pantalla la frase oculta.

    for ($i = 0; $i < count($frase); $i++) {
        if ($fraseUsuario[$i] != null) {
            /* if ($fraseUsuario[$key] == $frase[$key]) { */
            if ($fraseUsuario[$i] != $frase[$i] && $frase[$i] != " ") {
                echo "_";
            } else if ($frase[$i] == " ") {
                echo " ";
            } else if ($frase[$i] == $fraseUsuario[$i]) {
                echo $frase[$i];
            }
        } else {
            echo "_";
        }
    }

    echo "\n\n";
}

// Función para adivinar la frase.
function adivinarFrase($supuestaFrase): bool
{
    $b = true;
    $input = readline("¿Cuál crees que es?: ");

    if ($input == $supuestaFrase) {
        $b = true;
    } else {
        $b = false;
    }

    return $b;
}


do {
    global $fraseRandom, $fallos, $ganador;
    checkInfo();

    // Pedimos al usuario la letra.
    $respuestaUsuario = readline("Letra: ");
    $respuestaUsuario = mb_strtolower($respuestaUsuario, "UTF-8");

    $count = 0; // contador de letras encontradas.
    $fallosActuales = 0; // fallos que ha tenido en la ronda.

    // También filtraremos los datos para que no hayan errores a la hora de escribir la letra.
    if (
        !is_numeric($respuestaUsuario)
        && is_string($respuestaUsuario)
        && !preg_match('/[\'^£$%&*()}{@#~?><>,|=_+¬-]/', $respuestaUsuario)
        && $respuestaUsuario != "/"
        && strlen($respuestaUsuario) == 1
        && $respuestaUsuario != null && $respuestaUsuario != " "
    ) {

        // Si el usuario ha acertado la letra, lo añade al contador.
        // Este lo usaremos para revisar los fallos, aciertos o si tiene que añadirse
        // al array de letras correctas.
        foreach ($arrayFraseRandom as $key => $valor) {
            if ($respuestaUsuario ==  $valor && !in_array($respuestaUsuario, $fraseUsuario)) {
                $count++;
            }
        }

        // Revisa si la letra está en el array y si hay aciertos.
        // si no está, la añade al array que forma el usuario y si está ya la letra, te suma un fallo.
        if ($count > 0 && !in_array($respuestaUsuario, $fraseUsuario)) {

            foreach ($arrayFraseRandom as $key => $valor) {
                if ($respuestaUsuario ==  $valor) {
                    $fraseUsuario[$key] = $respuestaUsuario;
                }
            }

            $letrasAcertadas += $count;
            echo "Hay " . $count . ". Acertadas: " . $letrasAcertadas . "\n";

            checkInfo();

            // Si ha adivinado todas las letras de la frase, gana.
            if ($letrasAcertadas == count($arrayFraseRandom)) {
                $ganador = true;
                // Si aun no la ha adivinado, le pregunta al usuario si quiere adivinar. 
            } else {
                $quieroAdivinar = readline("¿Quieres adivinar ya? [s/n]: ");
                $quieroAdivinar = mb_strtolower($quieroAdivinar, "UTF-8"); // convertimos la respuesta en minúsculas

                // Si no ha fallado o ha ganado aun, proce
                if ($fallosActuales == 0 && $ganador != true) {

                    // comprobamos la respuesta del usuario al querer adivinar.
                    if ($quieroAdivinar == "s" || $quieroAdivinar == "si") {
                        if (adivinarFrase($fraseRandom)) {
                            $ganador = true;
                            break;
                        } else {
                            $fallos++;
                            $ganador = false;
                        }
                    } else if ($quieroAdivinar == "n" || $quieroAdivinar == "no") {
                        $ganador = false;
                    } else {
                        $ganador = false;
                    }
                }
            }
        } else if ($count == 0 && in_array($respuestaUsuario, $fraseUsuario)) {
            echo "Vaya! Parece que ya está. \n";
            $fallos++;
            $fallosActuales = 1;
        } else {
            $fallos++;
            $fallosActuales = 1;
        }

        // Comprueba los fallos.
        if ($fallos == 6) {
            checkInfo();
            echo "Has perdido :(\nLa frase era: " . $fraseRandom;
            break;
            // Si las letras que ha encontrado el usuario coinciden con las letras de la frase, ha ganado.
        }
    } else {
        // Mensaje de que no ha indicado bien el valor.
        echo "Algo anda mal.\n";
    }
} while ($ganador == false);

if ($ganador == true) {
    echo "Has ganado!!";
}
