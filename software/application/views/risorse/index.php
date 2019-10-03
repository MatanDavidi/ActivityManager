<!-- breadcrumb start-->
<section class="breadcrumb breadcrumb_bg align-items-center">
    <div class="container">
        <div class="row align-items-center justify-content-between">
            <div class="col-sm-6">
                <div class="breadcrumb_tittle">
                    <p>Mostra tutti i collaboratori e le risorse</p>
                    <h2>Risorse</h2>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- breadcrumb end-->

<div class="container mt-5 mb-4">
    <div class="row">
        <a href="<?php echo URL; ?>risorse/aggiungi" class="col-sm-3 mb-2 ml-auto btn btn-success">
            <i class="ti-plus"></i> REGISTRA RISORSA
        </a>
    </div>
    <div class="row">
        <p class="text-info">Numero di risorse registrate: xx</p>
    </div>
    <div class="row border border-dark rounded pt-3 pb-3">
        <div class="activity-table col-xl-2 col-md-4 col-sm-6 col-xs-12">
            <a href="<?php echo URL . "risorse/dettagli/0"; ?>">
                <p class="list-group-item list-group-item-action">Roberto Gervasoni</p>
                <p class="list-group-item">Costo all'ora: xxx.xx</p>
            </a>
        </div>
        <div class="activity-table col-xl-2 col-md-4 col-sm-6 col-xs-12">
            <a href="<?php echo URL . "risorse/dettagli/0"; ?>">
                <p class="list-group-item list-group-item-action">Franco Rezzonico</p>
                <p class="list-group-item">Costo all'ora: xxx.xx</p>
            </a>
        </div>
    </div>
</div>

<!--<div class="container mt-5 mb-4">-->
<!--    <form action="--><?php //echo URL . "risorse/aggiungi"; ?><!--" method="post">-->
<!--        <div class="form-group">-->
<!--            <label for="nome">Nome: </label>-->
<!--            <input class="form-control" type="text" name="nome" id="nome" required>-->
<!--        </div>-->
<!--        <div class="form-group">-->
<!--            <label for="costo">Costo: </label>-->
<!--            <input class="form-control" type="number" step="0.05" name="costo" id="costo" required>-->
<!--        </div>-->
<!--        <div class="form-group">-->
<!--            <label for="data_consegna">Data di consegna: <span class="text-danger">*</span></label>-->
<!--            <input class="form-control" type="date" name="data_consegna" id="data_consegna" required>-->
<!--        </div>-->
<!--        <div class="form-group">-->
<!--            <label for="ore">Numero di ore preventivato: <span class="text-danger">*</span></label>-->
<!--            <input class="form-control" type="number" name="ore" id="ore" required>-->
<!--        </div>-->
<!--        <div class="form-group">-->
<!--            <label for="note">Note: </label>-->
<!--            <textarea class="form-control" name="note" id="note" cols="30" rows="10"></textarea>-->
<!--        </div>-->
<!--        <div class="row col-12 mx-0 px-0 mt-5">-->
<!--            <div class="col-xs-12 col-lg-6 px-0">-->
<!--                <a href="--><?php //echo URL . "lavori"; ?><!--" class="btn btn-danger btn-block">-->
<!--                    <i class="ti-close"></i> ANNULLA-->
<!--                </a>-->
<!--            </div>-->
<!--            <div class="col-xs-12 col-lg-6 px-0">-->
<!--                <button class="btn btn-success btn-block" type="submit">-->
<!--                    <i class="ti-pencil-alt"></i> INSERISCI-->
<!--                </button>-->
<!--            </div>-->
<!--        </div>-->
<!--    </form>-->
<!--</div>-->