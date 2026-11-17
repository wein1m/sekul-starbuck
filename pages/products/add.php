<?php
include "../../include/header.php"
?>
    <div class="container ">
        <div class="row">
            <div class="col-3"></div>
            <div class="col-6 mt-5">
                <form class="form-floating" action="../../process/process_product.php" method="POST">
                    <input type="hidden" name="action" value="add">
                    <div class="form-floating my-3">
                        <label for="floatingInput">Nama Produk</label>
                        <input name="nama_produk" class="form-control" id="floatingInput" placeholder="Oat Milk">
                    </div>
                    <div class="form-floating my-3">
                        <label for="floatingInput">Harga Produk</label>
                        <input type="number" step="any" name="harga" class="form-control" id="floatingInput" placeholder="123.76">
                    </div>
                    <button type="submit" class="btn-solid theme-success px-5 mt-5">Submit</button>
                </form>
            </div>
            <div class="col-3"></div>
        </div>
    </div>
<?php
include "../../include/footer.php"
?>
