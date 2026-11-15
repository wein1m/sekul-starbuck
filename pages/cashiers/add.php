<?php
include "../../include/header.php"
?>
    <div class="container ">
        <div class="row">
            <div class="col-3"></div>
            <div class="col-6 mt-5">
                <form class="form-floating" action="../../process/process_cashier.php" method="POST">
                    <input type="hidden" name="action" value="add">
                    <div class="form-floating my-3">
                        <label for="floatingInput">Nama Kasir</label>
                        <input name="nama" class="form-control" id="floatingInput" placeholder="wein">
                    </div>
                    <div class="form-floating my-3">
                        <label for="floatingInput">No Telp</label>
                        <input name="telp" class="form-control" id="floatingInput" placeholder="wein">
                    </div>
                    <div class="form-floating my-3">
                        <label for="floatingPassword">Alamat</label>
                        <input name="alamat" class="form-control" id="floatingPassword" placeholder="Password">
                    </div>
                    <div class="form-floating my-3">
                        <label for="floatingPassword">Email</label>
                        <input name="email" type="email" class="form-control" id="floatingInput" placeholder="name@example.com">
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
