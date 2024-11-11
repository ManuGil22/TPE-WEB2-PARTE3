<?php
require_once "db.model.php";
class TripModel extends dbModel {
 
    public function getTrips($orderBy, $order, $limit, $offset) {
        $sql = 'SELECT viajes.id AS viaje_id,
                usuarios.id AS usuario_id,
                viajes.*,
                usuarios.*
                FROM viajes JOIN usuarios ON usuarios.id=viajes.user_id';

        if($orderBy) {
            switch($orderBy) {
                case 'pais':
                    $sql .= ' ORDER BY pais';
                    break;
                case 'pais_destino':
                    $sql .= ' ORDER BY pais_destino';
                    break;
                case 'ciudad':
                    $sql .= ' ORDER BY ciudad';
                    break;
                case 'ciudad_destino':
                    $sql .= ' ORDER BY ciudad_destino';
                    break;
                case 'fecha_ini':
                    $sql .= ' ORDER BY fecha_ini';
                    break;
                case 'fecha_fin':
                    $sql .= ' ORDER BY fecha_fin';
                    break;
                case 'nombre':
                    $sql .= ' ORDER BY nombre';
                    break;
                case 'apellido':
                    $sql .= ' ORDER BY apellido';
                    break;
                default:
                    $sql .= ' ORDER BY pais';
            }
            $sql .= ' ' . $order;
        }

        $sql .= ' LIMIT ' . $limit . ' OFFSET ' . $offset;

        $query = $this->db->prepare($sql);
        $query->execute();
    
        $trips = $query->fetchAll(PDO::FETCH_OBJ); 
    
        return $trips;
    }

    
    public function getTrip($id) {
        $query = $this->db->prepare('SELECT viajes.id AS viaje_id,
                                    viajes.*,
                                    usuarios.* 
                                    FROM viajes JOIN usuarios ON usuarios.id=viajes.user_id 
                                    WHERE viajes.id=?');
        $query->execute([$id]);

        $trip = $query->fetchAll(PDO::FETCH_OBJ);

        return $trip;
    }

    public function editTrip($trip) {
        $query = $this->db->prepare('UPDATE viajes 
                                    SET 
                                        pais = ?, 
                                        ciudad = ?, 
                                        pais_destino = ?, 
                                        ciudad_destino = ?, 
                                        fecha_ini = ?, 
                                        fecha_fin = ?, 
                                        user_id = ?
                                    WHERE 
                                        id = ?');
        $query->execute([$trip->departureCountry, $trip->departureCity, $trip->arrivalCountry, $trip->arrivalCity, $trip->startDate, $trip->endDate, $trip->passenger, $trip->id]);
    
        $id = $this->db->lastInsertId();
    
        return $id;
    }

    public function addTrip($trip) {
        $query = $this->db->prepare('INSERT INTO viajes 
                            (pais, ciudad, pais_destino, ciudad_destino, fecha_ini, fecha_fin, user_id) 
                            VALUES (?, ?, ?, ?, ?, ?, ?)');
        $query->execute([$trip->departureCountry, $trip->departureCity, $trip->arrivalCountry, $trip->arrivalCity, $trip->startDate, $trip->endDate, $trip->passenger]);
    
        $id = $this->db->lastInsertId();
    
        return $id;
    }
}