<?php
    include_once("templates/header.php");
    include_once("process/orders.php");
    ?>
   
   <div id="main-container">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h2>Gerenciar pedidos:</h2>
            </div>
            <div class="col-md-12 table-container">
                <table class="table">
                    <tread>
                        <tr>
                            <th scope="col"><span>Pedido</span> #</th>
                            <th scope="col">Cobertura</th>
                            <th scope="col">Guloseima</th>
                            <th scope="col">Sabores</th>
                            <th scope="col">Status</th>
                            <th scope="col">Ações</th>
                        </tr>
                    </tread>
                    <tbody>
                        <?php foreach ($sorvetes as $sorvete): ?>
                            <tr>
                            <td><?= $sorvete["id"] ?></td>
                            <td><?= $sorvete["cobertura"] ?></td>
                            <td><?= $sorvete["guloseima"] ?></td>
                            <td>
                                <ul>
                                    <?php foreach($sorvete["sabores"] as $sabor): ?>
                                        <li><?= $sabor ;?></li>
                                        <?php endforeach; ?>
                                </ul>
                            </td>
                            <td>
                                <form action="process/orders.php" method="POST" class="form-group update-form">
                                    <input type="hidden" name="type" value="update">
                                    <input type="hidden" name="id" value="<?= $sorvete["id"] ?>">
                                    <select name="status" class="form-control status-input">
                                    <?php foreach($status as $s): ?>
                                        <option value="<?= $s["id"] ?>" <?php echo ($s["id"] == $sorvete["status"]) ? "selected" : ""; ?> ><?= $s["tipo"] ?></option>
                                        <?php endforeach; ?>

                                    </select>
                                        <button type="submit" class="update-btn">
                                            <i class="fas fa-sync-alt"></i>
                                        </button>
                                </form>
                            </td>
                            <td>
                                <form action="process/orders.php" method="POST">
                                    <input type="hidden" name="type" value="delete">
                                    <input type="hidden" name="id" value="<?= $sorvete["id"] ?>">
                                    <button type="submit" class="delete-btn">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                            <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
   </div>
 
   <?php
    include_once("templates/footer.php");
    ?>