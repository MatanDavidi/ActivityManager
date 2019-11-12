<!-- breadcrumb start-->
<section class="breadcrumb breadcrumb_bg align-items-center">
    <div class="container">
        <div class="row align-items-center justify-content-between">
            <div class="col-sm-6">
                <div class="breadcrumb_tittle">
                    <p>
                        Mostra i dettagli della risorsa '<?php echo $resource->getName(); ?>'
                    </p>
                    <h2>Dettagli</h2>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- breadcrumb end-->

<div class="container mt-5 mb-4">
    <div class="row col-xs-12 col-lg-4 mb-1 ml-0">
        <a href="<?php echo URL . "resources"; ?>" class="btn btn-danger btn-block">
            <i class="ti-arrow-left"></i> TORNA ALLA LISTA DELLE RISORSE
        </a>
    </div>
    <div class="row border border-dark rounded p-3">
        <div class="col-12">
            <h1 class="text-center">
                <?php echo $resource->getName(); ?>
            </h1>
        </div>
        <div class="col-12">
            <p class="text-info">
                Costo all'ora: <?php echo $resource->getHourCost(); ?>
            </p>
            <p class="text-info">
                Ruolo: <?php echo $resource->getRole(); ?>
            </p>
            <p class="text-info">
                Numero di lavori assegnati: <?php echo $assignedActivitiesCount; ?>
            </p>
        </div>
        <ul class="list-group col-12 mt-2">
            <li class="list-group-item">
                <p>Attività assegnate:</p>
            </li>
            <?php if ($assignedActivitiesCount > 0):
                foreach ($assignedActivities as $assignedActivity): ?>
                    <a href="<?php echo URL . "activities/details/" . urlencode($assignedActivity->getName()); ?>">
                        <li class="list-group-item list-group-item-action">
                            <?php echo $assignedActivity->getName(); ?>
                        </li>
                    </a>
                <?php endforeach; ?>
            <?php else: ?>
                <li class="list-group-item">
                    <div class="col-12 text-center">
                        <p class="text-primary">Non è stato trovato nessun lavoro a cui la risorsa è stata
                            assegnata.</p>
                    </div>
                </li>
            <?php endif; ?>

        </ul>
    </div>