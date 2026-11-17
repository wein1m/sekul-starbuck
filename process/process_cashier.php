<?php

include "../config/config.php";

try {
    $conn->beginTransaction();

    $data = [
        "nama" => $_POST["nama"],
        "telp" => $_POST["telp"],
        "alamat" => $_POST["alamat"],
        "email" => $_POST["email"],
    ];

    $id_kasir = $_POST["id_kasir"];

    switch ($_POST["action"]) {
        case "add":
            add_kasir($conn, $data);
            $conn->commit();
            alert("Data has been added~!", "../pages/cashiers/list.php");
        break;

        case "edit":
            edit_kasir($conn, $id_kasir, $data);
            $conn->commit();
            alert("Data has been saved~!", "../pages/cashiers/list.php");
        break;

        case "delete":
            delete_kasir($conn, $id_kasir);
            $conn->commit();
            alert("Data has been deleted~!", "../pages/cashiers/list.php");
        break;
    }
}
catch (PDOException $e) {
    $conn->rollBack();
    alert("Uwegghh, i fwailed to save data TT", '../pages/cashiers/add.php');
}

function alert($msg, $location) {
    echo "<script>alert('$msg');window.location.href='$location';</script>";
}

function add_kasir($conn, $data) {
    $query = "
        INSERT INTO Kasir
        (nama_kasir, no_telp, alamat, email)
        VALUES
        (:nama, :telp, :alamat, :email)
    ";

    $stmt = $conn->prepare($query);
    $stmt->execute($data);
}

function edit_kasir($conn, $id_kasir, $data) {
    $query = "
        UPDATE Kasir SET
        nama_kasir= :nama,
        no_telp= :telp,
        alamat= :alamat,
        email= :email
        WHERE id_kasir= :id_kasir
    ";

    $stmt = $conn->prepare($query);
    $stmt->execute([
        ...$data,
        "id_kasir" => $id_kasir
    ]);
}

function delete_kasir($conn, $id_kasir) {
    $query = "
        DELETE FROM Kasir
        WHERE id_kasir = :id_kasir
    ";

    $stmt = $conn->prepare($query);
    $stmt->execute([
        "id_kasir" => $id_kasir
    ]);
}
