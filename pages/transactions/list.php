<?php
    include "../../include/header.php";
?>
<center>
    <a href="/sekul-starbuck/pages/transactions/add.php" class="btn-solid theme-success mb-3">
        Tambah Transaksi
    </a>
</center>
<div class="container">
    <table class="table table-hover">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">No. Nota</th>
                <th scope="col">Kasir</th>
                <th scope="col">Tanggal & Waktu</th>
                <th scope="col">Item</th>
                <th scope="col">Subtotal</th>
                <th scope="col">Pajak (11%)</th>
                <th scope="col">Total</th>
                <th scope="col">Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php
            include '../../config/config.php';

            $query = "
                SELECT 
                    t.id_transaksi,
                    t.subtotal,
                    t.pajak,
                    t.total,
                    t.tanggal,
                    t.waktu,
                    (SELECT d.id_nota FROM Detail_Transaksi d WHERE d.id_transaksi = t.id_transaksi LIMIT 1) AS id_nota,
                    (SELECT k.nama_kasir FROM Detail_Transaksi d JOIN Kasir k ON d.id_kasir = k.id_kasir WHERE d.id_transaksi = t.id_transaksi LIMIT 1) AS nama_kasir,
                    (SELECT COUNT(*) FROM Detail_Transaksi d WHERE d.id_transaksi = t.id_transaksi) AS total_item
                FROM Transaksi t
                ORDER BY t.id_transaksi DESC
            ";
            $stmt = $conn->prepare($query);
            $stmt->execute();
            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

            $no = 1;
            foreach ($rows as $row):
            ?>
            <tr>
                <th scope="row"><?php echo $no++; ?></th>
                <td><strong><?php echo htmlspecialchars($row['id_nota'] ?? '-'); ?></strong></td>
                <td><?php echo htmlspecialchars($row['nama_kasir'] ?? '-'); ?></td>
                <td><?php echo htmlspecialchars($row['tanggal'] . ' ' . $row['waktu']); ?></td>
                <td><?php echo htmlspecialchars($row['total_item']); ?> produk</td>
                <td><?php echo number_format($row['subtotal'], 2); ?></td>
                <td><?php echo number_format($row['pajak'], 2); ?></td>
                <td><strong><?php echo number_format($row['total'], 2); ?></strong></td>
                <td>
                    <a href='detail.php?id_transaksi=<?php echo $row['id_transaksi']; ?>' class='btn-solid theme-primary'>Detail</a>
                    <a href='edit.php?id_transaksi=<?php echo $row['id_transaksi']; ?>' class='btn-solid theme-warning'>Edit</a>

                    <form action="/sekul-starbuck/process/process_transaction.php"
                          method="POST"
                          style="display: inline;"
                    >
                        <input type="hidden" name="action" value="delete">
                        <input type="hidden" name="id_transaksi"
                            value="<?php echo $row['id_transaksi']; ?>">

                        <button type="submit"
                                class="btn-solid theme-danger"
                                onclick="return confirm('Apakah Anda yakin ingin menghapus transaksi ini?')">
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
