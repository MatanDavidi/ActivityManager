<!-- breadcrumb start-->
<section class="breadcrumb breadcrumb_bg align-items-center">
    <div class="container">
        <div class="row align-items-center justify-content-between">
            <div class="col-sm-12">
                <div class="breadcrumb_tittle">
                    <p>Mostra i lavori in corso</p>
                    <h2>Lavori</h2>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- breadcrumb end-->

<div class="container mt-5 mb-4">
    <div class="row">
        <?php if ($_SESSION["userRole"] == Resource::ADMINISTRATOR_ROLE): ?>
            <a href="<?php echo URL; ?>activities/new" class="col-sm-3 mb-2 btn btn-success">
                <i class="ti-plus"></i> NUOVO LAVORO
            </a>
        <?php endif; ?>
        <a href="<?php echo URL; ?>resources" class="col-sm-3 mb-2 ml-auto btn btn-danger">
            <i class="ti-user"></i> GESTISCI RISORSE
        </a>
    </div>
    <div class="row border border-dark rounded pt-3 pb-3">
        <?php if (count($activities) > 0): ?>
            <?php for ($i = 0; $i < count($activities); ++$i): ?>
                <?php $activity = $activities[$i]; ?>
                <div class="activity-table col-xl-2 col-md-4 col-sm-6 col-xs-12">
                    <a href="<?php echo URL . "activities/details/" . urlencode($activity->getName()); ?>">
                        <p class="list-group-item list-group-item-action overflow-hidden overflow-ellipse"
                           data-toggle="tooltip"
                           data-placement="top"
                           title="<?php echo $activity->getName(); ?>">
                            <?php echo $activity->getName(); ?>
                        </p>
                        <p class="list-group-item">
                            Data di inizio:
                            <?php
                            $startDate = $activity->getStartDate();
                            echo $startDate->format("d.m.Y");
                            ?>
                        </p>
                        <p class="list-group-item">
                            Data di consegna:
                            <?php
                            $deliveryDate = $activity->getDeliveryDate();
                            echo $deliveryDate->format("d.m.Y");
                            ?>
                        </p>
                        <p class="list-group-item">
                            Ore di lavoro preventivate: <?php echo $activity->getEstimatedHours(); ?>
                        </p>
                        <p class="list-group-item">Collaboratori assegnati:
                            <?php
                            echo $assignedResourcesCounts[$i];
                            ?>
                        </p>
                    </a>
                </div>
            <?php endfor; ?>
        <?php else: ?>
            <div class="col-12 text-center">
                <p class="text-primary">Non è stato trovato nessun lavoro.</p>
            </div>
        <?php endif; ?>
    </div>
</div>