<?php

namespace Controllers;

use Model\Servicio;
use Model\Cita;
use Model\CitaServicio;

class APIController {
    public static function index() {
        $servicios = Servicio::all();

        echo json_encode($servicios);
    }

    public static function guardar() {
        
        //Almacena la Cita y devuelve el id
        $cita = new Cita($_POST);
        $resultado = $cita->guardar();

        $id = $resultado['id'];

        //Almacena la Cita y el Servicio/os

        /*explode es el equivalente a split de JS*/
        $idServicios = explode(',', $_POST['servicios']); 

        //ALMACENA LOS SERVICIOS CON EL ID DE LA CITA
        foreach ($idServicios as $idServicio) {
            $args = [
                'citaId' => $id,
                'servicioId' =>$idServicio
            ];
            $citaServicio = new CitaServicio($args);
            $citaServicio->guardar();
        };

        

        echo json_encode( ['resultado' => $resultado] );
    }

    public static function eliminar() {
        $id = $_POST['id'];
        $cita = Cita::find($id);
        $cita->eliminar();
        header('Location: '. $_SERVER['HTTP_REFERER']);
    }
}