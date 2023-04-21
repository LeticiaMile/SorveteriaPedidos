<?php
    include_once("templates/header.php");
    include_once("process/sorvete.php");
    ?>
   <div id="main-banner">
    <h1>Faça seu pedido</h1>
   </div>
   <div id="main-container">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h2>Monte seu sorvete como desejar:</h2>
                <form action="process/sorvete.php" method="POST" id="sorvete-form">
                    <div class="form-group">
                        <label for="cobertura">Cobertura:</label>
                        <select name="cobertura" id="cobertura" class="form-control">
                            <option value="">Selecione a cobertura</option>
                            <?php foreach($coberturas as $cobertura): ?>
                                <option value="<?= $cobertura["id"] ?>"><?= $cobertura["tipo"] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="guloseima">Guloseima:</label>
                        <select name="guloseima" id="guloseima" class="form-control">
                            <option value="">Selecione a guloseima</option>
                            <?php foreach($guloseimas as $guloseima): ?>
                                <option value="<?= $guloseima["id"] ?>"><?= $guloseima["tipo"] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="sabores">Sabores: (Máximo 3)</label>
                        <select multiple name="sabores[]" id="sabores" class="form-control">
                        <?php foreach($sabores as $sabor): ?>
                                <option value="<?= $sabor["id"] ?>"><?= $sabor["nome"] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <input type="submit" class="btn btn-primary" value="Fazer Pedido!">
                        
                    </div>
                </form>
            </div>
        </div>
    </div>
   </div>
   <?php
    include_once("templates/footer.php");
    ?>