<?php
    include "../../include/header.php";
    include "../../config/config.php";

    $id = $_GET['id_produk'];

    $query = "SELECT * FROM Produk WHERE id_produk = '$id'";
    $stmt = $conn->prepare($query);
    $stmt->execute();

    $row = $stmt->fetch(PDO::FETCH_ASSOC);
?>

<div class="container">
    <div class="row">
        <div class="col-3"></div>
        <div class="col-6 mt-5">
            <form action="../../process/process_product.php" method="post">
                <input type="hidden" name="action" value="edit">
                <input type="hidden" name="id_produk" value="<?php echo $row['id_produk']; ?>">
                <div class="form-floating mt-5">
                    <label for="floatingInput">Nama Produk</label>
                    <input type="text" name="nama_produk" value="<?php echo $row['nama_produk']; ?>" class="form-control"
                        id="floatingInput" placeholder="Nama Produk">
                </div>
                <div class="form-floating mt-5">
                    <label for="floatingInput">Harga Produk</label>
                    <input type="number" step="any" name="harga" value="<?php echo $row['harga']; ?>" class="form-control"
                        id="floatingInput" placeholder="Harga Produk">
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
