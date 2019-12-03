<!-- breadcrumb start-->
<section class="breadcrumb breadcrumb_bg align-items-center">
    <div class="container">
        <div class="row align-items-center justify-content-between">
            <div class="col-sm-12">
                <div class="breadcrumb_tittle">
                    <p>
                        Resoconto mensile delle ore di lavoro
                    </p>
                    <h2>Resoconto mensile</h2>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- breadcrumb end-->

<div class="container mt-5 mb-4">
    <div class="col-xs-12 col-lg-3 px-0">
        <a href="<?php echo URL . "activities"; ?>" class="btn btn-danger btn-block mb-3">
            <i class="ti-arrow-circle-left"></i> TORNA ALLA LISTA DI ATTIVITÀ
        </a>
    </div>
    <form action="<?php echo URL . "workHours/monthlyReport"; ?>" id="monthForm" method="post">
        <div class="form-group">
            <label for="mese">Mese: </label>
            <input class="form-control" type="month" name="mese" id="mese" placeholder="YYYY-MM"
                   value="<?php echo date("Y-m"); ?>">
        </div>
        <input class="btn btn-outline-primary btn-block" type="submit" value="INVIA">
    </form>
    <div id="main" class="col-xs-12 mt-3">
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                <tr>
                    <th scope="col">Data</th>
                    <th scope="col">Nome collaboratore</th>
                    <th scope="col">Nome lavoro</th>
                    <th scope="col">Ore di lavoro</th>
                    <th scope="col">Costo</th>
                </tr>
                </thead>
            </table>
        </div>
    </div>
</div>

<script src="/application/libs/js/additional-methods.min.js"></script>
<script src="/application/libs/js/form-validation/workHours-monthlyReport.js"></script>
<script src="/application/libs/js/custom/workHours-monthlyReport.js"></script>