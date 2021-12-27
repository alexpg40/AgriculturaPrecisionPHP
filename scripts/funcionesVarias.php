<?php

    function leerPuntosXML($ubicacion){
        $xml = simplexml_load_file("http://localhost/AgriculturaPrecisionPHP/ficheros/recintos/recintos.gml");
        $stringPuntos = $xml->featureMember->Recinto->geometry->Polygon->exterior->LinearRing->posList;
        $arrayPuntos = explode(' ', $stringPuntos);
        $puntos = array();
        for ($i=0; $i < count($arrayPuntos); $i+=2) { 
            $lat = $arrayPuntos[$i];
            $long = $arrayPuntos[$i+1];
            array_push($puntos, [$long, $lat]);
        }
        return $puntos;
    }

?>