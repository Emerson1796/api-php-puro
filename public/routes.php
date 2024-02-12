<?php

use Src\Controller\UsuarioController;
use Src\Controller\EstadoController;

require_once __DIR__ . '/vendor/autoload.php';

$usuarioController = new UsuarioController();
$estadoController = new EstadoController();


if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if ($_SERVER['REQUEST_URI'] === '/usuarios') {
        echo json_encode($usuarioController->index());
    } elseif (preg_match('/\/usuarios\/(\d+)/', $_SERVER['REQUEST_URI'], $matches)) {
        $id = $matches[1];
        echo json_encode($usuarioController->show($id));
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($_SERVER['REQUEST_URI'] === '/usuarios') {
        $data = json_decode(file_get_contents("php://input"), true);
        echo json_encode($usuarioController->create($data['nome'], $data['email']));
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'PUT') {
    if (preg_match('/\/usuarios\/(\d+)/', $_SERVER['REQUEST_URI'], $matches)) {
        $id = $matches[1];
        $data = json_decode(file_get_contents("php://input"), true);
        echo json_encode($usuarioController->update($id, $data['nome'], $data['email']));
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
    if (preg_match('/\/usuarios\/(\d+)/', $_SERVER['REQUEST_URI'], $matches)) {
        $id = $matches[1];
        echo json_encode($usuarioController->delete($id));
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if ($_SERVER['REQUEST_URI'] === '/estados') {
        echo json_encode($estadoController->index());
    } elseif (preg_match('/\/estados\/(\d+)/', $_SERVER['REQUEST_URI'], $matches)) {
        $id = $matches[1];
        echo json_encode($estadoController->show($id));
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_SERVER['REQUEST_URI'] === '/estados') {
    $data = json_decode(file_get_contents("php://input"), true);
    echo json_encode($estadoController->create($data['nome'], $data['sigla']));
}

if ($_SERVER['REQUEST_METHOD'] === 'PUT') {
    if (preg_match('/\/estados\/(\d+)/', $_SERVER['REQUEST_URI'], $matches)) {
        $id = $matches[1];
        $data = json_decode(file_get_contents("php://input"), true);
        echo json_encode($estadoController->update($id, $data['nome'], $data['sigla']));
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
    if (preg_match('/\/estados\/(\d+)/', $_SERVER['REQUEST_URI'], $matches)) {
        $id = $matches[1];
        echo json_encode($estadoController->delete($id));
    }
}
