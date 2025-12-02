<?php
$severName = "(localdb)\MSSQLLocalDB";
$database = "DBAPI";
$authentication = "Windows Authentication";

try {
    $conn = new PDO("sqlsrv:server=$severName;Database=$database;TrustServerCertificate=true", 
        null,
        null);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode ([
        "error" => "Error de conexion a la base de datos",
        "detalle" => $e->getMessage()
    ]);

    exit();
}
?>