<!-- breadcrumb start-->
<section class="breadcrumb breadcrumb_bg align-items-center">
    <div class="container">
        <div class="row align-items-center justify-content-between">
            <div class="col-sm-6">
                <div class="breadcrumb_tittle">
                    <p>Assegna una risorsa al lavoro 'Lavoro 0'</p>
                    <h2>Assegnazione</h2>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- breadcrumb end-->

<div class="container mt-5 mb-4">
    <form action="<?php echo URL . "assignments/assegna"; ?>" method="post">
        <div id="lavoroSelect" class="form-group">
            <label for="lavoro">Lavoro:</label>
            <select class="wide disabled" name="lavoro" id="lavoro" required>
                <option value="Lavoro 0" selected>Lavoro 0</option>
            </select>
            <div class="error-container"></div>
        </div>
        <div id="risorsaSelect" class="form-group">
            <label for="risorsa">Risorsa:</label>
            <select class="wide" name="risorsa" id="risorsa">
                <option value="">-- SCEGLI --</option>
                <option value="Roberto Gervasoni">Roberto Gervasoni</option>
                <option value="Franco Rezzonico">Franco Rezzonico</option>
            </select>
            <div class="error-container"></div>
        </div>
        <div class="row col-12 mx-0 px-0 mt-5">
            <div class="col-xs-12 col-lg-6 px-0">
                <a href="<?php echo URL . "activities/dettagli/0"; ?>" class="btn btn-danger btn-block">
                    <i class="ti-close"></i> ANNULLA
                </a>
            </div>
            <div class="col-xs-12 col-lg-6 px-0">
                <button class="btn btn-success btn-block" type="submit">
                    <i class="ti-save"></i> ASSEGNA
                </button>
            </div>
        </div>
    </form>
</div>

<script src="/application/libs/js/form-validation/assignments-assign.js"></script>
<script src="/application/libs/js/form-validation/select-validation.js"></script>