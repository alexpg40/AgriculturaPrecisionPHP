<?php

    function leerPuntosXML(){
        $xml = simplexml_load_file("http://localhost/AgriculturaPrecisionPHP/ficheros/recintos/recintos.gml");
        $stringPuntos = $xml->featureMember->Recinto->geometry->Polygon->exterior->LinearRing->posList;
        $arrayPuntos = explode(' ', $stringPuntos);
        $puntos = array();
        for ($i=0; $i < count($arrayPuntos); $i+=2) { 
            $lat = $arrayPuntos[$i];
            $long = $arrayPuntos[$i+1];
            array_push($puntos, [$long, $lat]);
        }
        $stringArea = $xml->featureMember->Recinto->dn_surface[0];
        $stringMunicipio = $xml->featureMember->Recinto->municipio[0];
        $stringProvincia = $xml->featureMember->Recinto->provincia[0];
        return array($puntos, (string) $stringArea, (string) $stringMunicipio, (string) $stringProvincia);
    }

?>