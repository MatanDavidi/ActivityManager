<!-- breadcrumb start-->
<section class="breadcrumb breadcrumb_bg align-items-center">
    <div class="container">
        <div class="row align-items-center justify-content-between">
            <div class="col-sm-6">
                <div class="breadcrumb_tittle">
                    <p>Registra le ore di lavoro per l'attività 'Lavoro 0'</p>
                    <h2>Ore lavoro</h2>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- breadcrumb end-->

<div class="container mt-5 mb-4">
    <form action="<?php echo URL . "oreLavoro/registra"; ?>" method="post">
        <div class="form-group">
            <label for="lavoro">Lavoro:</label>
            <select class="wide disabled" name="lavoro" id="lavoro" required>
                <option value="Lavoro 0" selected>Lavoro 0</option>
            </select>
        </div>
        <div class="form-group">
            <label for="risorsa">Risorsa:</label>
            <select class="wide" name="risorsa" id="risorsa" required>
                <option value="Roberto Gervasoni">Roberto Gervasoni</option>
                <option value="Franco Rezzonico">Franco Rezzonico</option>
            </select>
        </div>
        <div class="form-group">
            <label for="data">Data:</label>
            <input class="form-control" type="date" name="data" id="data" required>
        </div>
        <div class="form-group">
            <label for="numeroOre">Numero di ore di lavoro:</label>
            <input class="form-control" type="number" name="numeroOre" id="numeroOre"
                   min="1" required>
        </div>
        <div class="row col-12 mx-0 px-0 mt-1">
            <div class="col-xs-12 col-lg-6 px-0">
                <a href="<?php echo URL . "lavori/dettagli/0"; ?>" class="btn btn-danger btn-block">
                    <i class="ti-close"></i> ANNULLA
                </a>
            </div>
            <div class="col-xs-12 col-lg-6 px-0">
                <button class="btn btn-success btn-block" type="submit">
                    <i class="ti-write"></i> REGISTRA
                </button>
            </div>
        </div>
    </form>
</div>

<script src="/application/libs/js/form-validation/oreLavoro-registra.js"></script>