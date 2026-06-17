<?php
declare(strict_types=1);

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\App;

// Importando conexión a la base de datos
require __DIR__ . '/../src/db.php';

return function (App $app) {

    // PAra registros Hospitales

    // Agregar un Hospital
    $app->post('/hospitales/nuevo', function (Request $request, Response $response) {
        $datos = $request->getParsedBody();
        $sql = "INSERT INTO Hospitales (IdHospital, NomHospital, CapacidadAtencion, Especialidades) 
                VALUES (:id, :nombre, :capacidad, :especialidades)";

        try {
            $db = new db();
            $conn = $db->connect();
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':id', $datos['IdHospital']);
            $stmt->bindParam(':nombre', $datos['NomHospital']);
            $stmt->bindParam(':capacidad', $datos['CapacidadAtencion']);
            $stmt->bindParam(':especialidades', $datos['Especialidades']);
            $stmt->execute();
            $conn = null;

            $response->getBody()->write(json_encode(["mensaje" => "Hospital guardado con exito"]));
            return $response->withHeader('Content-Type', 'application/json')->withStatus(201);
        } catch (PDOException $e) {
            $response->getBody()->write(json_encode(["error" => $e->getMessage()]));
            return $response->withHeader('Content-Type', 'application/json')->withStatus(500);
        }
    });

    // Consultar un Hospital
    $app->get('/hospitales/buscar/{nombre}', function (Request $request, Response $response, array $args) {
        // busqueda por coincidencias
        $nombre = "%" . $args['nombre'] . "%"; 
        $sql = "SELECT * FROM Hospitales WHERE NomHospital LIKE :nombre";

        try {
            $db = new db();
            $conn = $db->connect();
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':nombre', $nombre);
            $stmt->execute();
            // multiples resultados
            $hospitales = $stmt->fetchAll(PDO::FETCH_OBJ);
            $conn = null;

            $response->getBody()->write(json_encode($hospitales));
            return $response->withHeader('Content-Type', 'application/json');
        } catch (PDOException $e) {
            $response->getBody()->write(json_encode(["error" => $e->getMessage()]));
            return $response->withHeader('Content-Type', 'application/json')->withStatus(500);
        }
    });

    //Para registros doctores

    //Agregar un Doctor
    $app->post('/doctores/nuevo', function (Request $request, Response $response) {
        $datos = $request->getParsedBody();
        $sql = "INSERT INTO Doctores (IdDoctor, NombresDoctor, ApellidosDoctor, Especialidad, TurnoAtencion, PacientesMinDiarios, Sueldo, IdHospital) 
                VALUES (:idDoctor, :nombres, :apellidos, :especialidad, :turno, :pacientes, :sueldo, :idHospital)";

        try {
            $db = new db();
            $conn = $db->connect();
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':idDoctor', $datos['IdDoctor']);
            $stmt->bindParam(':nombres', $datos['NombresDoctor']);
            $stmt->bindParam(':apellidos', $datos['ApellidosDoctor']);
            $stmt->bindParam(':especialidad', $datos['Especialidad']);
            $stmt->bindParam(':turno', $datos['TurnoAtencion']);
            $stmt->bindParam(':pacientes', $datos['PacientesMinDiarios']);
            $stmt->bindParam(':sueldo', $datos['Sueldo']);
            $stmt->bindParam(':idHospital', $datos['IdHospital']);
            $stmt->execute();
            $conn = null;

            $response->getBody()->write(json_encode(["mensaje" => "Doctor guardado con exito"]));
            return $response->withHeader('Content-Type', 'application/json')->withStatus(201);
        } catch (PDOException $e) {
            $response->getBody()->write(json_encode(["error" => $e->getMessage()]));
            return $response->withHeader('Content-Type', 'application/json')->withStatus(500);
        }
    });

    // Consultar los registros Doctores
    $app->get('/doctores', function (Request $request, Response $response) {
        $sql = "SELECT * FROM Doctores";

        try {
            $db = new db();
            $conn = $db->connect();
            $stmt = $conn->query($sql);
            $doctores = $stmt->fetchAll(PDO::FETCH_OBJ);
            $conn = null;

            $response->getBody()->write(json_encode($doctores));
            return $response->withHeader('Content-Type', 'application/json');
        } catch (PDOException $e) {
            $response->getBody()->write(json_encode(["error" => $e->getMessage()]));
            return $response->withHeader('Content-Type', 'application/json')->withStatus(500);
        }
    });
};
