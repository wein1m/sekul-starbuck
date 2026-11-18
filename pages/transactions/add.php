<?php
include "../../include/header.php";
include "../../config/config.php";

// Ambil daftar kasir
$kasir_stmt = $conn->prepare("SELECT * FROM Kasir ORDER BY nama_kasir ASC");
$kasir_stmt->execute();
$kasir_list = $kasir_stmt->fetchAll(PDO::FETCH_ASSOC);

// Ambil daftar produk
$produk_stmt = $conn->prepare("SELECT * FROM Produk ORDER BY nama_produk ASC");
$produk_stmt->execute();
$produk_list = $produk_stmt->fetchAll(PDO::FETCH_ASSOC);

$default_nota = "Chk " . rand(2000, 9999);
$default_tanggal = date("Y-m-d");
$default_waktu = date("H:i:s");
?>

<div class="container my-5">
    <div class="row">
        <div class="col-12">
            <h3 class="mb-4 text-center">Tambah Transaksi Baru</h3>
            <form action="../../process/process_transaction.php" method="POST" id="transactionForm">
                <input type="hidden" name="action" value="add">

                <div class="card p-4 mb-4">
                    <h5>Informasi Transaksi</h5>
                    <div class="row g-3 mt-2">
                        <div class="col-md-3">
                            <label class="form-label">No. Nota</label>
                            <input type="text" name="id_nota" class="form-control" value="<?php echo htmlspecialchars($default_nota); ?>" required>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Kasir</label>
                            <select name="id_kasir" class="form-control" required>
                                <option value="" disabled selected>-- Pilih Kasir --</option>
                                <?php foreach ($kasir_list as $kasir): ?>
                                    <option value="<?php echo $kasir['id_kasir']; ?>">
                                        <?php echo htmlspecialchars($kasir['nama_kasir']); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Tanggal</label>
                            <input type="date" name="tanggal" class="form-control" value="<?php echo $default_tanggal; ?>" required>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Waktu</label>
                            <input type="time" step="1" name="waktu" class="form-control" value="<?php echo $default_waktu; ?>" required>
                        </div>
                    </div>
                </div>

                <div class="card p-4 mb-4">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h5 class="mb-0">Daftar Produk</h5>
                        <button type="button" class="btn-solid theme-success" id="addRowBtn">+ Tambah Produk</button>
                    </div>

                    <table class="table" id="itemsTable">
                        <thead>
                            <tr>
                                <th style="width: 35%;">Produk</th>
                                <th style="width: 20%;">Kategori</th>
                                <th style="width: 15%;">Harga Satuan</th>
                                <th style="width: 10%;">Qty</th>
                                <th style="width: 15%;">Subtotal</th>
                                <th style="width: 5%;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody id="itemsBody">
                            <!-- Baris pertama default -->
                            <tr class="item-row">
                                <td>
                                    <select name="items[0][id_produk]" class="form-control product-select" required>
                                        <option value="" disabled selected>-- Pilih Produk --</option>
                                        <?php foreach ($produk_list as $prod): ?>
                                            <option value="<?php echo $prod['id_produk']; ?>" data-harga="<?php echo $prod['harga']; ?>">
                                                <?php echo htmlspecialchars($prod['nama_produk']) . " (Rp " . number_format($prod['harga'], 2) . ")"; ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </td>
                                <td>
                                    <select name="items[0][kategori]" class="form-control category-select" required>
                                        <option value="Minuman" selected>Minuman</option>
                                        <option value="Makanan">Makanan</option>
                                        <option value="Tambahan">Tambahan</option>
                                    </select>
                                </td>
                                <td>
                                    <input type="number" step="any" name="items[0][harga]" class="form-control price-input" value="0.00" readonly>
                                </td>
                                <td>
                                    <input type="number" min="1" value="1" name="items[0][kuantitas]" class="form-control qty-input" required>
                                </td>
                                <td>
                                    <input type="number" step="any" name="items[0][kuantitas_harga]" class="form-control item-subtotal" value="0.00" readonly>
                                </td>
                                <td>
                                    <button type="button" class="btn-solid theme-danger remove-row-btn" disabled>&times;</button>
                                </td>
                            </tr>
                        </tbody>
                    </table>

                    <div class="row justify-content-end mt-3">
                        <div class="col-md-4">
                            <ul class="list-group">
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <span>Subtotal:</span>
                                    <strong id="displaySubtotal">0.00</strong>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <span>Pajak (11%):</span>
                                    <strong id="displayPajak">0.00</strong>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center bg-light">
                                    <span>Total Akhir:</span>
                                    <h5 class="mb-0" id="displayTotal">0.00</h5>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-between">
                    <a href="list.php" class="btn-solid theme-secondary">Kembali</a>
                    <button type="submit" class="btn-solid theme-success px-5">Simpan Transaksi</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    let rowIndex = 1;
    const itemsBody = document.getElementById('itemsBody');
    const addRowBtn = document.getElementById('addRowBtn');

    // Template opsi produk dari PHP
    const productOptionsHtml = `
        <option value="" disabled selected>-- Pilih Produk --</option>
        <?php foreach ($produk_list as $prod): ?>
            <option value="<?php echo $prod['id_produk']; ?>" data-harga="<?php echo $prod['harga']; ?>">
                <?php echo htmlspecialchars($prod['nama_produk']) . " (Rp " . number_format($prod['harga'], 2) . ")"; ?>
            </option>
        <?php endforeach; ?>
    `;

    addRowBtn.addEventListener('click', function () {
        const tr = document.createElement('tr');
        tr.className = 'item-row';
        tr.innerHTML = `
            <td>
                <select name="items[${rowIndex}][id_produk]" class="form-control product-select" required>
                    ${productOptionsHtml}
                </select>
            </td>
            <td>
                <select name="items[${rowIndex}][kategori]" class="form-control category-select" required>
                    <option value="Minuman" selected>Minuman</option>
                    <option value="Makanan">Makanan</option>
                    <option value="Tambahan">Tambahan</option>
                </select>
            </td>
            <td>
                <input type="number" step="any" name="items[${rowIndex}][harga]" class="form-control price-input" value="0.00" readonly>
            </td>
            <td>
                <input type="number" min="1" value="1" name="items[${rowIndex}][kuantitas]" class="form-control qty-input" required>
            </td>
            <td>
                <input type="number" step="any" name="items[${rowIndex}][kuantitas_harga]" class="form-control item-subtotal" value="0.00" readonly>
            </td>
            <td>
                <button type="button" class="btn-solid theme-danger remove-row-btn">&times;</button>
            </td>
        `;
        itemsBody.appendChild(tr);
        rowIndex++;
        updateRemoveButtons();
    });

    itemsBody.addEventListener('change', function (e) {
        if (e.target.classList.contains('product-select')) {
            const selected = e.target.options[e.target.selectedIndex];
            const harga = parseFloat(selected.getAttribute('data-harga')) || 0;
            const row = e.target.closest('tr');
            row.querySelector('.price-input').value = harga.toFixed(2);
            calculateRowSubtotal(row);
        }
    });

    itemsBody.addEventListener('input', function (e) {
        if (e.target.classList.contains('qty-input')) {
            const row = e.target.closest('tr');
            calculateRowSubtotal(row);
        }
    });

    itemsBody.addEventListener('click', function (e) {
        if (e.target.classList.contains('remove-row-btn')) {
            const rows = itemsBody.querySelectorAll('.item-row');
            if (rows.length > 1) {
                e.target.closest('tr').remove();
                updateTotals();
                updateRemoveButtons();
            }
        }
    });

    function calculateRowSubtotal(row) {
        const price = parseFloat(row.querySelector('.price-input').value) || 0;
        const qty = parseInt(row.querySelector('.qty-input').value) || 0;
        const subtotal = price * qty;
        row.querySelector('.item-subtotal').value = subtotal.toFixed(2);
        updateTotals();
    }

    function updateTotals() {
        let subtotal = 0;
        document.querySelectorAll('.item-subtotal').forEach(el => {
            subtotal += parseFloat(el.value) || 0;
        });

        const pajak = subtotal * 0.11;
        const total = subtotal + pajak;

        document.getElementById('displaySubtotal').innerText = subtotal.toFixed(2);
        document.getElementById('displayPajak').innerText = pajak.toFixed(2);
        document.getElementById('displayTotal').innerText = total.toFixed(2);
    }

    function updateRemoveButtons() {
        const rows = itemsBody.querySelectorAll('.item-row');
        rows.forEach(row => {
            const btn = row.querySelector('.remove-row-btn');
            if (rows.length === 1) {
                btn.disabled = true;
            } else {
                btn.disabled = false;
            }
        });
    }
</script>

<?php
include "../../include/footer.php";
?>
