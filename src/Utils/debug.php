<?php

error_reporting(E_ALL); //włacza wyświetlanie wszystkich błędów
ini_set('display_errors', '1'); 
//zaleca się urzywanie obu powyższaych funkcji aby mieć pełny zakres błędów



//nasza własna funkcja debagująca
function dump($data)
{
    $color = ['lightgreen', 'lightcoral', 'lightgray', 'lightsalmon'];
    static $licz =0;
    echo '<br/><div style="
        display: inline-block;
        padding: 0 10px;
        border: 1px solid gray;
        background:'.$color[($licz++)%count($color)].';
        "
    >
    <pre>';

    print_r($data);
    echo '</pre>
    </div>
    <br/>';
}

