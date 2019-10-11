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
        <a href="<?php echo URL; ?>lavori" class="col-sm-3 mb-2 btn btn-info">
            <i class="ti-agenda"></i> GESTISCI LAVORI
        </a>
        <a href="<?php echo URL; ?>risorse/aggiungi"
           class="col-sm-3 ml-auto mb-2 btn btn-success">
            <i class="ti-plus"></i> REGISTRA RISORSA
        </a>
    </div>
    <div class="row">
        <p class="text-info mt-auto">Numero di risorse registrate: xx</p>
    </div>
    <div class="row border border-dark rounded pt-3 pb-3">
        <div class="activity-table col-xl-2 col-md-4 col-sm-6 col-xs-12">
            <a href="<?php echo URL . "resources/dettagli/0"; ?>">
                <p class="list-group-item list-group-item-action">Roberto Gervasoni</p>
                <p class="list-group-item">Costo all'ora: xxx.xx</p>
            </a>
        </div>
        <div class="activity-table col-xl-2 col-md-4 col-sm-6 col-xs-12">
            <a href="<?php echo URL . "resources/dettagli/0"; ?>">
                <p class="list-group-item list-group-item-action">Franco Rezzonico</p>
                <p class="list-group-item">Costo all'ora: xxx.xx</p>
            </a>
        </div>
    </div>
</div>