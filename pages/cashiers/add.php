<?php
include "../../include/header.php"
?>
    <div class="container ">
        <div class="row">
            <div class="col-3"></div>
            <div class="col-6 mt-5">
                <form class="form-floating" method="POST">
                    <div class="form-floating my-3">
                        <label for="floatingInput">Nama Kasir</label>
                        <input class="form-control" id="floatingInput" placeholder="wein">
                    </div>
                    <div class="form-floating my-3">
                        <label for="floatingInput">No Telp</label>
                        <input class="form-control" id="floatingInput" placeholder="wein">
                    </div>
                    <div class="form-floating my-3">
                        <label for="floatingPassword">Alamat</label>
                        <input class="form-control" id="floatingPassword" placeholder="Password">
                    </div>
                    <div class="form-floating my-3">
                        <label for="floatingPassword">Email</label>
                        <input type="email" class="form-control" id="floatingInput" placeholder="name@example.com">
                    </div>
                    <button type="button" class="btn-solid theme-primary mt-5">Submit</button>
                </form>
            </div>
            <div class="col-3"></div>
        </div>
    </div>
<?php
include "../../include/footer.php"
?>
