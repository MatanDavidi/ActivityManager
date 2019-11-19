<!-- breadcrumb start-->
<section class="breadcrumb breadcrumb_bg align-items-center">
    <div class="container">
        <div class="row align-items-center justify-content-between">
            <div class="col-sm-12">
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
        <a href="<?php echo URL; ?>activities" class="col-sm-3 mb-2 btn btn-info">
            <i class="ti-agenda"></i> GESTISCI LAVORI
        </a>
        <?php if ($_SESSION["userRole"] == Resource::ADMINISTRATOR_ROLE): ?>
            <a href="<?php echo URL; ?>resources/add"
               class="col-sm-3 ml-auto mb-2 btn btn-success">
                <i class="ti-plus"></i> REGISTRA RISORSA
            </a>
        <?php endif; ?>
    </div>
    <div class="row">
        <p class="text-info mt-auto">Numero di risorse registrate: <?php echo $resourcesCount; ?></p>
    </div>
    <div class="row border border-dark rounded pt-3 pb-3">
        <?php if (count($resources) > 0): ?>
            <?php foreach ($resources as $resource): ?>
                <div class="activity-table col-xl-2 col-md-4 col-sm-6 col-xs-12">
                    <a href="<?php echo URL . "resources/details/" . urlencode($resource->getName()); ?>">
                        <p class="list-group-item list-group-item-action overflow-hidden overflow-ellipse"
                           data-toggle="tooltip"
                           data-placement="top"
                           title="<?php echo $resource->getName(); ?>">
                            <?php echo $resource->getName(); ?>
                        </p>
                        <p class="list-group-item">
                            Costo all'ora: <?php echo $resource->getHourCost(); ?>
                        </p>
                    </a>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="col-12 text-center">
                <p class="text-primary">Non è stata trovata nessuna risorsa.</p>
            </div>
        <?php endif; ?>
    </div>
</div>