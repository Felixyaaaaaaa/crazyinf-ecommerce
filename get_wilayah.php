<?php
header('Content-Type: application/json');

$tipe = $_POST['tipe'] ?? '';
$id   = $_POST['id'] ?? '';

function get_json($path) {
    return file_exists($path) ? json_decode(file_get_contents($path), true) : [];
}

$base = __DIR__ . "/data-indonesia";

switch ($tipe) {
    case 'provinsi':
        echo json_encode(get_json("$base/provinsi.json"));
        break;

    case 'kabupaten':
        echo json_encode(get_json("$base/kabupaten/{$id}.json"));
        break;

    case 'kecamatan':
        echo json_encode(get_json("$base/kecamatan/{$id}.json"));
        break;

    case 'kelurahan':
        echo json_encode(get_json("$base/kelurahan/{$id}.json"));
        break;

    default:
        echo json_encode([]);
        break;
}
