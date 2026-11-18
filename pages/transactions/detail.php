<?php
include "../../include/header.php";
include "../../config/config.php";

$id_transaksi = isset($_GET['id_transaksi']) ? intval($_GET['id_transaksi']) : 0;

// Ambil data transaksi induk
$stmtTx = $conn->prepare("SELECT * FROM Transaksi WHERE id_transaksi = :id_transaksi");
$stmtTx->execute(['id_transaksi' => $id_transaksi]);
$transaksi = $stmtTx->fetch(PDO::FETCH_ASSOC);

if (!$transaksi) {
    echo "<div class='container my-5'><div class='alert alert-danger'>Transaksi tidak ditemukan!</div><a href='list.php' class='btn-solid theme-secondary'>Kembali</a></div>";
    include "../../include/footer.php";
    exit;
}

// Ambil detail item transaksi
$queryDetails = "
    SELECT 
        d.*,
        p.nama_produk,
        k.nama_kasir
    FROM Detail_Transaksi d
    LEFT JOIN Produk p ON d.id_produk = p.id_produk
    LEFT JOIN Kasir k ON d.id_kasir = k.id_kasir
    WHERE d.id_transaksi = :id_transaksi
    ORDER BY d.id_detail_transaksi ASC
";
$stmtDetails = $conn->prepare($queryDetails);
$stmtDetails->execute(['id_transaksi' => $id_transaksi]);
$details = $stmtDetails->fetchAll(PDO::FETCH_ASSOC);

$firstItem = !empty($details) ? $details[0] : null;
$nama_kasir = $firstItem ? ($firstItem['nama_kasir'] ?? '-') : '-';
$id_nota = $firstItem ? ($firstItem['id_nota'] ?? '-') : '-';
?>

<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card p-4 shadow-sm border">
                <div class="text-center mb-4">
                    <h2 class="mb-1">STARBUCKS</h2>
                    <p class="text-muted mb-0">Struk Pembelian / Detail Transaksi</p>
                </div>

                <hr>

                <div class="row mb-3">
                    <div class="col-6">
                        <strong>No. Nota:</strong> <?php echo htmlspecialchars($id_nota); ?><br>
                        <strong>ID Transaksi:</strong> #<?php echo htmlspecialchars($transaksi['id_transaksi']); ?><br>
                        <strong>Kasir:</strong> <?php echo htmlspecialchars($nama_kasir); ?>
                    </div>
                    <div class="col-6 text-end">
                        <strong>Tanggal:</strong> <?php echo htmlspecialchars($transaksi['tanggal']); ?><br>
                        <strong>Waktu:</strong> <?php echo htmlspecialchars($transaksi['waktu']); ?>
                    </div>
                </div>

                <table class="table table-bordered mb-4">
                    <thead>
                        <tr class="table-light">
                            <th style="width: 5%;">#</th>
                            <th>Produk</th>
                            <th>Kategori</th>
                            <th class="text-end">Harga</th>
                            <th class="text-center">Qty</th>
                            <th class="text-end">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $no = 1;
                        foreach ($details as $item): 
                        ?>
                        <tr>
                            <td><?php echo $no++; ?></td>
                            <td><?php echo htmlspecialchars($item['nama_produk'] ?? 'Produk #' . $item['id_produk']); ?></td>
                            <td><?php echo htmlspecialchars($item['kategori']); ?></td>
                            <td class="text-end"><?php echo number_format($item['harga'], 2); ?></td>
                            <td class="text-center"><?php echo htmlspecialchars($item['kuantitas']); ?></td>
                            <td class="text-end"><?php echo number_format($item['kuantitas_harga'], 2); ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <th colspan="5" class="text-end">Subtotal:</th>
                            <td class="text-end"><?php echo number_format($transaksi['subtotal'], 2); ?></td>
                        </tr>
                        <tr>
                            <th colspan="5" class="text-end">Pajak (11%):</th>
                            <td class="text-end"><?php echo number_format($transaksi['pajak'], 2); ?></td>
                        </tr>
                        <tr class="table-light">
                            <th colspan="5" class="text-end fs-5">Total Akhir:</th>
                            <td class="text-end fs-5 fw-bold"><?php echo number_format($transaksi['total'], 2); ?></td>
                        </tr>
                    </tfoot>
                </table>

                <div class="d-flex justify-content-between no-print">
                    <a href="list.php" class="btn-solid theme-secondary">Kembali ke Daftar</a>
                    <div>
                        <a href="edit.php?id_transaksi=<?php echo $transaksi['id_transaksi']; ?>" class="btn-solid theme-warning me-2">Edit</a>
                        <button type="button" onclick="window.print()" class="btn-solid theme-primary">Cetak Struk</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
@media print {
    .navbar, .no-print, footer, .btn-solid {
        display: none !important;
    }
    .card {
        border: none !important;
        box-shadow: none !important;
    }
}
</style>

<?php
include "../../include/footer.php";
?>
