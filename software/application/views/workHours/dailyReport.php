<!-- breadcrumb start-->
<section class="breadcrumb breadcrumb_bg align-items-center">
    <div class="container">
        <div class="row align-items-center justify-content-between">
            <div class="col-sm-12">
                <div class="breadcrumb_tittle">
                    <p>
                        Resoconto giornaliero delle ore di lavoro
                    </p>
                    <h2>Resoconto giornaliero</h2>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- breadcrumb end-->

<div class="container mt-5 mb-4">
    <div class="col-xs-12 col-lg-3 px-0">
        <a href="<?php echo URL . "resources"; ?>" class="btn btn-danger btn-block mb-3">
            <i class="ti-arrow-circle-left"></i> TORNA ALLA LISTA DI RISORSE
        </a>
    </div>
    <form action="<?php echo URL . "workHours/dailyReport"; ?>" id="dayForm" method="post">
        <div id="risorsaSelect" class="form-group">
            <label for="risorsa">Risorsa:</label>
            <select
                    class="wide
                    <?php if ($_SESSION["userRole"] == Resource::USER_ROLE) {
                        echo "disabled";
                    } ?>"
                    name="risorsa"
                    id="risorsa"
                    required>
                <?php if ($_SESSION["userRole"] == Resource::ADMINISTRATOR_ROLE): ?>
                    <option value="">--- SCEGLI ---</option>
                <?php endif; ?>
                <?php foreach ($resources as $resource): ?>
                    <?php if (!is_null($resource)): ?>
                        <option value="<?php echo $resource->getName(); ?>"><?php echo $resource->getName(); ?></option>
                    <?php endif; ?>
                <?php endforeach; ?>
            </select>
            <div class="error-container"></div>
        </div>
        <div class="form-group">
            <label for="data">Data: </label>
            <input class="form-control" type="date" name="data" id="data" placeholder="YYYY-MM-DD"
                   value="<?php echo date("Y-m-d"); ?>">
        </div>
        <input class="btn btn-outline-primary btn-block" type="submit" value="INVIA">
    </form>
    <div id="main" class="col-xs-12 mt-3">
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                <tr>
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
<script src="/application/libs/js/custom/workHours-dailyReport.js"></script>
<script src="/application/libs/js/form-validation/select-validation.js"></script>
<script src="/application/libs/js/form-validation/workHours-dailyReport.js"></script>