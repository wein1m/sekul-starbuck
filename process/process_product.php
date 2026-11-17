<?php

include "../config/config.php";

try {
    $conn->beginTransaction();

    $data = [
        "nama_produk" => $_POST["nama_produk"],
        "harga" => $_POST["harga"],
    ];

    $id_produk = $_POST["id_produk"];

    switch ($_POST["action"]) {
        case "add":
            add_kasir($conn, $data);
            $conn->commit();
            alert("Data has been added~!", "../pages/products/list.php");
        break;

        case "edit":
            edit_kasir($conn, $id_produk, $data);
            $conn->commit();
            alert("Data has been saved~!", "../pages/products/list.php");
        break;

        case "delete":
            delete_kasir($conn, $id_produk);
            $conn->commit();
            alert("Data has been deleted~!", "../pages/products/list.php");
        break;
    }
}
catch (PDOException $e) {
    $conn->rollBack();
    alert("Uwegghh, i fwailed to save data TT", '../pages/products/add.php');
}

function alert($msg, $location) {
    echo "<script>alert('$msg');window.location.href='$location';</script>";
}

function add_kasir($conn, $data) {
    $query = "
        INSERT INTO Produk
        (nama_produk, harga)
        VALUES
        (:nama_produk, :harga)
    ";

    $stmt = $conn->prepare($query);
    $stmt->execute($data);
}

function edit_kasir($conn, $id_produk, $data) {
    $query = "
        UPDATE Produk SET
        nama_produk= :nama_produk,
        harga= :harga
        WHERE id_produk= :id_produk
    ";

    $stmt = $conn->prepare($query);
    $stmt->execute([
        ...$data,
        "id_produk" => $id_produk
    ]);
}

function delete_kasir($conn, $id_produk) {
    $query = "
        DELETE FROM Produk
        WHERE id_produk = :id_produk
    ";

    $stmt = $conn->prepare($query);
    $stmt->execute([
        "id_produk" => $id_produk
    ]);
}
;
