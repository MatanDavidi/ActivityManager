<!-- breadcrumb start-->
<section class="breadcrumb breadcrumb_bg align-items-center">
    <div class="container">
        <div class="row align-items-center justify-content-between">
            <div class="col-sm-12">
                <div class="breadcrumb_tittle">
                    <p>Mostra i dettagli del lavoro '<?php echo $activity->getName(); ?>'</p>
                    <h2>Dettagli</h2>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- breadcrumb end-->

<div class="container mt-5 mb-4">
    <div class="row col-xs-12 col-lg-4 mb-1 ml-0">
        <a href="<?php echo URL . "activities"; ?>" class="btn btn-danger btn-block">
            <i class="ti-arrow-left"></i> TORNA ALLA LISTA DEI LAVORI
        </a>
    </div>
    <div class="row border border-dark rounded p-3">
        <div class="col-12">
            <h1 class="text-center"><?php echo $activity->getName() ?></h1>
            <p class="text-center text-dark"><?php echo $activity->getNotes(); ?></p>
        </div>
        <div class="col-lg-4 col-xs-12 border border-info p-1 text-center">
            <p>
                Data di inizio:
                <?php
                $startDate = $activity->getStartDate();
                echo $startDate->format("d.m.Y");
                ?>
            </p>
            <p>
                Data di consegna:
                <?php
                $deliveryDate = $activity->getDeliveryDate();
                echo $deliveryDate->format("d.m.Y");
                ?>
            </p>
            <p>
                Ore di lavoro preventivate:
                <?php echo $activity->getEstimatedHours(); ?>
            </p>
            <p>
                Ore di lavoro effettive:
                <?php echo $totalWorkHours; ?>
            </p>
            <p>
                Numero di risorse assegnate:
                <?php
                echo $resourcesNumber;
                ?>
            </p>
            <p>
                Costo complessivo: <?php echo number_format($totalCost, 2); ?> CHF
            </p>
        </div>
        <div class="col-xs-12 col-lg-4 ml-auto mt-lg-auto mt-2">
            <?php if ($_SESSION["userRole"] == Resource::ADMINISTRATOR_ROLE): ?>
                <a href="<?php echo URL . "assignments/assign/" . urlencode($activity->getName()); ?>"
                   class="btn btn-success btn-block">
                    <i class="ti-plus"></i> ASSEGNA RISORSA
                </a>
            <?php endif; ?>
            <a href="<?php echo URL . "workHours/register/" . urlencode($activity->getName()); ?>"
               class="btn btn-success btn-block">
                <i class="ti-time"></i> REGISTRA LAVORO
            </a>
        </div>
        <!-- Risorse assegnate-->
        <div class="col-xs-12 col-lg-6 mt-lg-3 card">
            <div class="card-body">
                <h4 class="card-title">Risorse assegnate</h4>
                <table class="table table-responsive-sm">
                    <thead>
                    <tr>
                        <th scope="col">Nome risorsa</th>
                        <th scope="col">Costo all'ora</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php if (count($assignedResources) > 0): ?>
                        <?php foreach ($assignedResources as $resource) : ?>
                            <tr>
                                <th scope="row">
                                    <a href="<?php echo URL . "resources/details/" . urlencode($resource->getName()); ?>">
                                        <?php
                                        echo $resource->getName();
                                        ?>
                                    </a>
                                </th>
                                <td><?php echo number_format($resource->getHourCost(), 2); ?> CHF</td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <th class="text-center" colspan="4">
                                <p class="text-primary">Non è stata trovata alcuna risorsa assegnata a questo lavoro.</p>
                            </th>
                        </tr>
                    <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
        <!-- Ore di lavoro-->
        <div class="col-xs-12 col-lg-6 mt-3 card">
            <div class="card-body">
                <h4 class="card-title">Ore di lavoro registrate</h4>
                <table class="table table-responsive-sm">
                    <thead>
                    <tr>
                        <th scope="col">Nome risorsa</th>
                        <th scope="col">Data lavoro</th>
                        <th scope="col">Ore lavoro</th>
                        <th scope="col">Costo</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php if (count($assignedWorkHours) > 0): ?>
                        <?php for ($i = 0; $i < count($assignedWorkHours); ++$i): ?>
                            <?php
                            $workHours = $assignedWorkHours[$i];
                            $workHoursCost = $workHoursCosts[$i];
                            $resource = $workHours->getResource();
                            ?>
                            <tr>
                                <th scope="row">
                                    <a href="<?php echo URL . "resources/details/" . urlencode($resource->getName()); ?>">
                                        <?php
                                        echo $resource->getName();
                                        ?>
                                    </a>
                                </th>
                                <td>
                                    <?php
                                    $date = $workHours->getDate();
                                    echo $date->format("d.m.Y");
                                    ?>
                                </td>
                                <td><?php echo $workHours->getHoursNumber(); ?></td>
                                <td><?php echo number_format($workHoursCost, 2); ?> CHF</td>
                            </tr>
                        <?php endfor; ?>
                    <?php else: ?>
                        <tr>
                            <th class="text-center" colspan="4">
                                <p class="text-primary">Non è state trovata alcuna ora di lavoro.</p>
                            </th>
                        </tr>
                    <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>