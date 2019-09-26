<!-- breadcrumb start-->
<section class="breadcrumb breadcrumb_bg align-items-center">
    <div class="container">
        <div class="row align-items-center justify-content-between">
            <div class="col-sm-6">
                <div class="breadcrumb_tittle">
                    <p>Accedi alla piattaforma</p>
                    <h2>Login</h2>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- breadcrumb start-->

<div class="container mt-5 mb-4">
    <div class="row align-items-center">
        <div class="col-lg-12">
            <form action="<?php echo URL; ?>home/login" method="post">
                <div class="form-group">
                    <label for="name">Nome:</label>
                    <input class="form-control"
                           type="text" name="name" id="name">
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
    </div>
</div>