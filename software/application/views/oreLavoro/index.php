<!-- breadcrumb start-->
<section class="breadcrumb breadcrumb_bg align-items-center">
    <div class="container">
        <div class="row align-items-center justify-content-between">
            <div class="col-sm-6">
                <div class="breadcrumb_tittle">
                    <p>Registra le ore di lavoro per l'attività 'Lavoro 0'</p>
                    <h2>Ore lavoro</h2>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- breadcrumb end-->

<div class="container mt-5 mb-4">
    <form action="<?php echo URL . "oreLavoro/registra"; ?>" method="post">
        <div class="form-group">
            <label for="lavoro">Lavoro:</label>
            <select class="wide disabled" name="lavoro" id="lavoro">
                <option value="Lavoro 0" selected>Lavoro 0</option>
            </select>
        </div>
        <div class="form-group">
            <label for="risorsa">Risorsa:</label>
            <select class="wide" name="risorsa" id="risorsa">
                <option value="Roberto Gervasoni">Roberto Gervasoni</option>
                <option value="Franco Rezzonico">Franco Rezzonico</option>
            </select>
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
        <input class="btn btn-success btn-block" type="submit" value="REGISTRA">
    </form>
</div>