<!-- breadcrumb start-->
<section class="breadcrumb breadcrumb_bg align-items-center">
    <div class="container">
        <div class="row align-items-center justify-content-between">
            <div class="col-sm-6">
                <div class="breadcrumb_tittle">
                    <p>
                        Registra le ore di lavoro per l'attività '<?php echo $activity->getName(); ?>'
                    </p>
                    <h2>Ore lavoro</h2>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- breadcrumb end-->

<div class="container mt-5 mb-4">
    <form action="<?php echo URL . "workHours/register/" . urlencode($activity->getName()); ?>" method="post">
        <div id="lavoroSelect" class="form-group">
            <label for="lavoro">Lavoro:</label>
            <select class="wide disabled" name="lavoro" id="lavoro" required>
                <option value="<?php echo $activity->getName() ?>" selected>
                    <?php echo $activity->getName(); ?>
                </option>
            </select>
            <div class="error-container"></div>
        </div>
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
                    <option value="<?php echo $resource->getName(); ?>"><?php echo $resource->getName(); ?></option>
                <?php endforeach; ?>
            </select>
            <div class="error-container"></div>
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
        <?php if (isset($err_msg)): ?>
            <p class="text-danger font-weight-bolder"><?php echo $err_msg; ?></p>
        <?php endif; ?>
        <div class="row col-12 mx-0 px-0 mt-1">
            <div class="col-xs-12 col-lg-6 px-0">
                <a href="<?php echo URL . "activities/details/" . urlencode($activity->getName()); ?>"
                   class="btn btn-danger btn-block">
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

<script src="/application/libs/js/form-validation/workHours-register.js"></script>
<script src="/application/libs/js/form-validation/select-validation.js"></script>