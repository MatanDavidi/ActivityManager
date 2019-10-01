<!-- breadcrumb start-->
<section class="breadcrumb breadcrumb_bg align-items-center">
    <div class="container">
        <div class="row align-items-center justify-content-between">
            <div class="col-sm-6">
                <div class="breadcrumb_tittle">
                    <p>Assegna una risorsa al lavoro 'Lavoro 0'</p>
                    <h2>Assegnazione</h2>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- breadcrumb end-->

<div class="container mt-5 mb-4">
    <form action="<?php echo URL . "assegnazioni/assegna"; ?>" method="post">
        <div>
            <div class="form-group">
                <label for="lavoro">Lavoro:</label>
                <select class="wide disabled" name="lavoro" id="lavoro">
                    <option value="Lavoro 1" selected>Lavoro 0</option>
                </select>
            </div>
            <div class="form-group">
                <label for="risorsa">Risorsa:</label>
                <select class="wide" name="risorsa" id="risorsa">
                    <option value=""></option>
                    <option value="Roberto Gervasoni">Roberto Gervasoni</option>
                    <option value="Franco Rezzonico">Franco Rezzonico</option>
                </select>
            </div>
        </div>
        <input class="btn btn-success mt-2 col-12" type="submit" value="ASSEGNA">
    </form>
</div>