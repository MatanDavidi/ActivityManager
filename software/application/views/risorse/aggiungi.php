<!-- breadcrumb start-->
<section class="breadcrumb breadcrumb_bg align-items-center">
    <div class="container">
        <div class="row align-items-center justify-content-between">
            <div class="col-sm-6">
                <div class="breadcrumb_tittle">
                    <p>Registra una risorsa</p>
                    <h2>Nuovo</h2>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- breadcrumb end-->

<div class="container mt-5 mb-4">
    <form action="<?php echo URL . "risorse/nuovo"; ?>" method="post">
        <div class="form-group">
            <label for="nome">Nome: <span class="text-danger">*</span></label>
            <input class="form-control" type="text" name="nome" id="nome" required>
        </div>
        <div class="form-group">
            <label for="costo">Costo all'ora: <span class="text-danger">*</span></label>
            <input class="form-control" type="number" step="0.05" name="costo" id="costo" min="0" required>
        </div>
        <div class="form-group">
            <label for="password">Password:</label>
            <input class="form-control" type="password" name="password" id="password">
        </div>
        <div id="ruolo" class="form-group">
            <label for="ruolo">
                Ruolo: <span class="text-danger">(obbligatorio se il campo 'password' è stato riempito)</span>
            </label>
            <div class="radio">
                <label for="amministratore">
                    <input type="radio" name="ruolo" id="amministratore" value="amministratore">Amministratore
                </label>
            </div>
            <div class="radio">
                <label for="utente">
                    <input type="radio" name="ruolo" id="utente" value="utente" checked>Utente
                </label>
            </div>
        </div>
        <div class="row col-12 mx-0 px-0 mt-5">
            <div class="col-xs-12 col-lg-6 px-0">
                <a href="<?php echo URL . "risorse"; ?>" class="btn btn-danger btn-block">
                    <i class="ti-close"></i> ANNULLA
                </a>
            </div>
            <div class="col-xs-12 col-lg-6 px-0">
                <button class="btn btn-success btn-block" type="submit">
                    <i class="ti-save-alt"></i> REGISTRA
                </button>
            </div>
        </div>
    </form>
</div>

