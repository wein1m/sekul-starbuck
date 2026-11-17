<?php
    include "../../include/header.php";
?>
<center>
    <a href="/sekul-starbuck/pages/products/add.php" class="btn-solid theme-success mb-3">Tambah
        Produk</a>
</center>
<div class="container">
    <table class="table table table-hover">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Nama Produk</th>
                <th scope="col">Harga</th>
                <th scope="col">Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php
            include '../../config/config.php';

            $query = "SELECT * FROM Produk";
            $stmt = $conn->prepare($query);
            $stmt->execute();
            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

            $no = 1;
            foreach ($rows as $row):
            ?>
            <tr>
                <th scope="row"><?php echo $no++; ?></th>
                <td><?php echo $row['nama_produk']; ?></td>
                <td><?php echo $row['harga']; ?></td>
                <td>
                    <a href='edit.php?id_produk=<?php echo $row['id_produk']; ?>' class='btn-solid theme-warning'>Edit</a>

                <form action="/sekul-starbuck/process/process_product.php"
                      method="POST"
                      style="display: inline;"
                >
                    <input type="hidden" name="action" value="delete">
                    <input type="hidden" name="id_produk"
                        value="<?php echo $row['id_produk']; ?>">

                    <button type="submit"
                            class="btn-solid theme-danger"
                            onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
                        Hapus
                    </button>
                </form>
                </td>
            </tr>
            <?php
            endforeach;
            ?>
        </tbody>
    </table>
</div>
<?php
    include '../../include/footer.php';
?>
