<?php
    include "../../include/header.php";
    include "../../config/config.php";

    $id = $_GET['id_kasir'];

    $query = "SELECT * FROM Kasir WHERE id_kasir = '$id'";
    $stmt = $conn->prepare($query);
    $stmt->execute();

    $row = $stmt->fetch(PDO::FETCH_ASSOC);
?>

<div class="container">
    <div class="row">
        <div class="col-3"></div>
        <div class="col-6 mt-5">
            <form action="../../process/process_cashier.php" method="post">
                <input type="hidden" name="action" value="edit">
                <input type="hidden" name="id_kasir" value="<?php echo $row['id_kasir']; ?>">
                <div class="form-floating mt-5">
                    <label for="floatingInput">Nama Kasir</label>
                    <input type="text" name="nama" value="<?php echo $row['nama_kasir']; ?>" class="form-control"
                        id="floatingInput" placeholder="Nama Kasir">
                </div>
                <div class="form-floating mt-5">
                    <label for="floatingInput">No Telp</label>
                    <input type="number" name="telp" value="<?php echo $row['no_telp']; ?>" class="form-control"
                        id="floatingInput" placeholder="No Telp">
                </div>
                <div class="form-floating mt-5">
                    <label for="floatingInput">Alamat</label>
                    <input type="text" name="alamat" value="<?php echo $row['alamat']; ?>" class="form-control"
                        id="floatingInput" placeholder="Alamat">
                </div>
                <div class="form-floating mt-5">
                    <label for="floatingInput">Email</label>
                    <input type="email" name="email" value="<?php echo $row['email']; ?>" class="form-control"
                        id="floatingInput" placeholder="nama@contoh.com">
                </div>
                <button type="submit" class="btn-solid theme-warning mt-5">Edit Data</button>
            </form>
        </div>
        <div class="col-3"></div>
    </div>
</div>


<?php
    include '../../include/footer.php';
?>
