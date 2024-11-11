<?php
require_once './app/models/trip.model.php';
require_once './app/views/api.view.php';

class TripApiController {
    private $tripModel;
    private $view;

    public function __construct() {
        $this->tripModel = new TripModel();
        $this->view = new APIView();
    }

    public function getAllTrips($req, $res) {
        $orderBy = false;
        if(isset($req->query->orderBy))
            $orderBy = $req->query->orderBy;

        $order = 'ASC';
        if(isset($req->query->order))
            $order = $req->query->order;

        $limit = isset($req->query->limit) ? (int) $req->query->limit : 100;
        $page = isset($req->query->page) ? (int) $req->query->page : 1;
        $offset = ($page - 1) * $limit;

        $trips = $this->tripModel->getTrips($orderBy, $order, $limit, $offset);
        return $this->view->response($trips);
    }

    public function editTrip($req, $res) {
        if(!$res->user) {
            return $this->view->response("No autorizado", 401);
        }

        $id = $req->params->id;

        $trip = $this->tripModel->getTrip($id);
        if (!$trip) {
            return $this->view->response("El viaje con el id=$id no existe", 404);
        }

        if (empty($req->body->pais) || empty($req->body->pais_destino) || empty($req->body->ciudad) 
            || empty($req->body->ciudad_destino) || empty($req->body->fecha_ini) || empty($req->body->fecha_fin)
            || empty($req->body->user_id)) {
            return $this->view->response('Faltan completar datos', 400);
        }

        $trip = new stdClass();
        $trip->id = $id;
        $trip->departureCountry = $req->body->pais;       
        $trip->arrivalCountry = $req->body->pais_destino;       
        $trip->departureCity = $req->body->ciudad;
        $trip->arrivalCity = $req->body->ciudad_destino;
        $trip->startDate = $req->body->fecha_ini;
        $trip->endDate = $req->body->fecha_fin;
        $trip->passenger = $req->body->user_id;

        $this->tripModel->editTrip($trip);

        $trip = $this->tripModel->getTrip($id);
        $this->view->response($trip, 200);
    }

    public function getTrip($req, $res) {
        $id = $req->params->id;

        $trip = $this->tripModel->getTrip($id);

        if(!$trip) {
            return $this->view->response("El viaje con el id=$id no existe", 404);
        }

        return $this->view->response($trip);
    }

    public function addTrip($req, $res) {
        if(!$res->user) {
            return $this->view->response("No autorizado", 401);
        }

        if (empty($req->body->pais) 
            || empty($req->body->pais_destino)
            || empty($req->body->ciudad)
            || empty($req->body->ciudad_destino)
            || empty($req->body->fecha_ini)
            || empty($req->body->fecha_fin)
            || empty($req->body->user_id)) {
            return $this->view->response('Faltan completar datos', 400);
        }

        $trip = new stdClass();
        $trip->departureCountry = $req->body->pais;
        $trip->arrivalCountry = $req->body->pais_destino;
        $trip->departureCity = $req->body->ciudad;
        $trip->arrivalCity = $req->body->ciudad_destino;
        $trip->startDate = $req->body->fecha_ini;
        $trip->endDate = $req->body->fecha_fin;
        $trip->passenger = $req->body->user_id;

        $id = $this->tripModel->addTrip($trip);

        if (!$id) {
            return $this->view->response("Error al agregar viaje", 500);
        }

        $trip = $this->tripModel->getTrip($id);
        return $this->view->response($trip, 201);
    }
}
