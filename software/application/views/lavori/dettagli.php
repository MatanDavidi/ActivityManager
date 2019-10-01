<!-- breadcrumb start-->
<section class="breadcrumb breadcrumb_bg align-items-center">
    <div class="container">
        <div class="row align-items-center justify-content-between">
            <div class="col-sm-6">
                <div class="breadcrumb_tittle">
                    <p>Mostra i dettagli del lavoro 'Lavoro 0'</p>
                    <h2>Dettagli</h2>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- breadcrumb end-->

<div class="container mt-5 mb-4">
    <div class="row border border-dark rounded p-3">
        <div class="col-12">
            <h1 class="text-center">Lavoro 0</h1>
        </div>
        <div class="col-lg-4 col-xs-12 border border-info p-1 text-center">
            <p>Data di inizio: dd.mm.yyyy</p>
            <p>Data di consegna: dd.mm.yyyy</p>
            <p>Ore di lavoro preventivate: xxx</p>
            <p>Numero di risorse assegnate: xx</p>
            <p>Costo complessivo: xxx.xx CHF</p>
        </div>
        <a href="<?php echo URL . "assegnazioni"; ?>" class="mt-auto ml-auto btn btn-success">
            <i class="ti-plus"></i> ASSEGNA RISORSA
        </a>
        <div class="col-12 mt-3">
            <table class="table">
                <thead>
                <tr>
                    <th scope="col">Nome risorsa</th>
                    <th scope="col">Data lavoro</th>
                    <th scope="col">Ore lavoro</th>
                    <th scope="col">Costo</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <th scope="row">Roberto Gervasoni</th>
                    <td>25.03.2017</td>
                    <td>8</td>
                    <td>175.35 CHF</td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>