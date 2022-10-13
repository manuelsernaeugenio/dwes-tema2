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

/********************************************
 * Este board contiene el estado de la partida.
 */
$board = array(
    0 => <<<_END
            ____
            |    |
            |    
            |   
            |   
            |
        ---\n
        _END,
    1 => <<<_END
            ____
            |    |
            |    O
            |   
            |   
            |
        ---\n
        _END,
    2 => <<<_END
            ____
            |    |
            |    O
            |    |
            |   
            |
        ---\n
        _END,
    3 => <<<_END
            ____
            |    |
            |    O
            |   /|
            |   
            |
        ---\n
        _END,
    4 => <<<_END
            ____
            |    |
            |    O
            |   /|\
            |   
            |
        ---\n
        _END,
    5 => <<<_END
            ____
            |    |
            |    O
            |   /|\
            |   / 
            |
        ---\n
        _END,
    6 => <<<_END
            ____
            |    |
            |    O
            |   /|\
            |   / \
            |
        ---\n
        _END
);

/************************************************************
 * Obtenemos la frase aleatoria y la convertimos a un array.
 */
function getFraseRandom($frases): array
{
    // Elegimos aleatoriamente una frase del array.
    $random = rand(0, count($frases) - 1);
    $fraseRandom = $frases[$random];

    // Convertimos la frase array y obtenemos las letras.
    $arrayFraseRandom = mb_str_split($fraseRandom, 1, "UTF-8");

    return $arrayFraseRandom;
}


/*************************************************************
 * Procedemos a mostrar al usuario si quiere adivinar la frase.
 */
function adivinarFrase($supuestaFrase): bool
{
    $b = true;
    $quieresAdivinar = readline("¿Quieres adivinar la frase? [s/n]");

    if ($quieresAdivinar == "s") {
        $input = readline("¿Cuál crees que es?: ");
        if ($input == $supuestaFrase) {
            $b = true;
        } else {
            $b = false;
        }
    } else if ($quieresAdivinar == "n") {
        $b = false;
    }

    return $b;
}

function comprobarLetra($respuestaUsuario): bool
{
    $b = true;

    if (
        !is_numeric($respuestaUsuario)
        && is_string($respuestaUsuario)
        && !preg_match('/[\'^£$%&*()}{@#~?><>,|=_+¬-]/', $respuestaUsuario)
        && $respuestaUsuario != "/"
        && strlen($respuestaUsuario) == 1
        && $respuestaUsuario != null && $respuestaUsuario != " "
    ) {
        $b = true;
    } else {
        $b = false;
    }

    return $b;
}

function Letra($respuestaUsuario): bool
{
    $b = true;

    return $b;
}

$ganador = false;
$perdedor = false;
$fallos = 0;

do {
} while ($ganador == false && $perdedor == false);

if ($ganador) {
    echo "¡Has ganado!\n";
} else if ($perdedor) {
    echo "¡Has perdido!\n";
}
