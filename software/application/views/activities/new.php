<!-- breadcrumb start-->
<section class="breadcrumb breadcrumb_bg align-items-center">
    <div class="container">
        <div class="row align-items-center justify-content-between">
            <div class="col-sm-6">
                <div class="breadcrumb_tittle">
                    <p>Aggiungi un lavoro</p>
                    <h2>Nuovo</h2>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- breadcrumb end-->

<div class="container mt-5 mb-4">
    <form action="<?php echo URL . "activities/new"; ?>" method="post">
        <div class="form-group">
            <label for="nome">Nome: <span class="text-danger">*</span></label>
            <input class="form-control" type="text" name="nome" id="nome" required>
        </div>
        <div class="form-group">
            <label for="data_inizio">Data di inizio: <span class="text-danger">*</span></label>
            <input class="form-control" type="date" name="data_inizio" id="data_inizio" required>
        </div>
        <div class="form-group">
            <label for="data_consegna">Data di consegna: <span class="text-danger">*</span></label>
            <input class="form-control" type="date" name="data_consegna" id="data_consegna" required>
        </div>
        <div class="form-group">
            <label for="ore">Numero di ore preventivato: <span class="text-danger">*</span></label>
            <input class="form-control" type="number" name="ore" id="ore" min="1" required>
        </div>
        <div class="form-group">
            <label for="note">Note: </label>
            <textarea class="form-control" name="note" id="note" cols="30" rows="10"></textarea>
        </div>
        <div class="row col-12 mx-0 px-0 mt-5">
            <div class="col-xs-12 col-lg-6 px-0">
                <a href="<?php echo URL . "activities"; ?>" class="btn btn-danger btn-block">
                    <i class="ti-close"></i> ANNULLA
                </a>
            </div>
            <div class="col-xs-12 col-lg-6 px-0">
                <button class="btn btn-success btn-block" type="submit">
                    <i class="ti-pencil-alt"></i> INSERISCI
                </button>
            </div>
        </div>
    </form>
</div>

<script src="/application/libs/js/additional-methods.min.js"></script>
<script src="/application/libs/js/form-validation/activities-new.js"></script>