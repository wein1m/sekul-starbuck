<?php
    include "../../include/header.php";
?>
<center>
    <a href="/starbuck/pages/cashiers/add.php" class="btn-solid theme-success mb-3">Tambah
        Kasir</a>
</center>
<div class="container">
    <table class="table table table-hover">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Nama Kasir</th>
                <th scope="col">No Telepon</th>
                <th scope="col">Alamat</th>
                <th scope="col">Email</th>
                <th scope="col">Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php
            include '../../config/config.php';

            $query = "SELECT * FROM Kasir";
            $stmt = $conn->prepare($query);
            $stmt->execute();
            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

            $no = 1;
            foreach ($rows as $row):
            ?>
            <tr>
                <th scope="row"><?php echo $no++; ?></th>
                <td><?php echo $row['nama_kasir']; ?></td>
                <td><?php echo $row['no_telp']; ?></td>
                <td><?php echo $row['alamat']; ?></td>
                <td><?php echo $row['email']; ?></td>
                <td>
                    <a href='edit.php?id_kasir=<?php echo $row['id_kasir']; ?>' class='btn-solid theme-warning'>Edit</a>

                <form action="/sekul-starbuck/process/process_cashier.php"
                      method="POST"
                      style="display: inline;"
                >

                <input type="hidden" name="action" value="delete">
                <input type="hidden" name="id_kasir"
                       value="<?php echo $row['id_kasir']; ?>">

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
