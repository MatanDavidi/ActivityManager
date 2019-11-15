<!-- breadcrumb start-->
<section class="breadcrumb breadcrumb_bg align-items-center">
    <div class="container">
        <div class="row align-items-center justify-content-between">
            <div class="col-sm-12">
                <div class="breadcrumb_tittle">
                    <p>Accedi alla piattaforma</p>
                    <h2>Login</h2>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- breadcrumb end-->

<div class="container mt-5 mb-4">
    <div class="row align-items-center">
        <div class="col-lg-12">
            <form action="<?php echo URL; ?>home/login" method="post">
                <div class="form-group">
                    <label for="nome">Nome:</label>
                    <input class="form-control"
                           type="text" name="nome" id="nome">
                </div>
                <div class="form-group">
                    <label for="password">Password:</label>
                    <input class="form-control" type="password"
                           name="password"
                           id="password">
                </div>
                <input class="btn_1 btn-block" type="submit" value="Accedi">
            </form>
        </div>
        <?php if (isset($err_msg)): ?>
            <p class="text-danger"><?php echo $err_msg; ?></p>
        <?php endif; ?>
    </div>
</div>

<script src="/application/libs/js/additional-methods.min.js"></script>
<script src="/application/libs/js/form-validation/home-login.js"></script>