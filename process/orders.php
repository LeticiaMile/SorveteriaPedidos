<?php

include_once("conn.php");

$method = $_SERVER["REQUEST_METHOD"];

if ($method == "GET"){

    $pedidosQuery = $conn->query("SELECT * FROM pedidos;");

    $pedidos = $pedidosQuery->fetchAll();

    $sorvetes = [];

    //Montando sorvete
    foreach($pedidos as $pedido){

        $sorvete = [];

        // Definir array para o sorvete
        $sorvete["id"] = $pedido["sorvete_id"];

        //Resgatando o sorvete
        $sorveteQuery = $conn->prepare("SELECT * FROM sorvetes WHERE id = :sorvete_id");

        $sorveteQuery->bindParam(":sorvete_id", $sorvete["id"]);

        $sorveteQuery->execute();

        $sorveteData = $sorveteQuery->fetch(PDO::FETCH_ASSOC);

        //Resgatando a cobertura do sorvete

        $coberturaQuery = $conn->prepare("SELECT * FROM coberturas WHERE id = :cobertura_id");

        $coberturaQuery->bindParam(":cobertura_id", $sorveteData["cobertura_id"]);

        $coberturaQuery->execute();

        $cobertura = $coberturaQuery->fetch(PDO::FETCH_ASSOC);

        $sorvete["cobertura"] = $cobertura["tipo"];

        //Resgatando a guloseima do sorvete

        $guloseimaQuery = $conn->prepare("SELECT * FROM guloseimas WHERE id = :guloseima_id");

        $guloseimaQuery->bindParam(":guloseima_id", $sorveteData["guloseima_id"]);

        $guloseimaQuery->execute();

        $guloseima = $guloseimaQuery->fetch(PDO::FETCH_ASSOC);

        $sorvete["guloseima"] = $guloseima["tipo"];

        //Resgatando os sabores do sorvete

        $saboresQuery = $conn->prepare("SELECT * FROM sorvete_sabor WHERE sorvete_id = :sorvete_id");

        $saboresQuery->bindParam(":sorvete_id", $sorvete["id"]);

        $saboresQuery->execute();

        $sabores = $saboresQuery->fetchAll(PDO::FETCH_ASSOC);

        // Resgatando o nome dos sabores

        $saboresDoSorvete = [];

        $saborQuery = $conn->prepare("SELECT * FROM sabores WHERE id = :sabor_id");

        foreach($sabores as $sabor){

            $saborQuery->bindParam(":sabor_id", $sabor["sabor_id"]);

            $saborQuery->execute();

            $saborSorvete = $saborQuery->fetch(PDO::FETCH_ASSOC);

            array_push($saboresDoSorvete, $saborSorvete["nome"]);
        }

        $sorvete["sabores"] = $saboresDoSorvete;

        //Adicionar status do pedido

        $sorvete["status"] = $pedido["status_id"];

        //Adicionar array do sorvete, ao array dos sorvetes

        array_push($sorvetes, $sorvete);


    }

    //Resgatando os status

    $statusQuery = $conn->query("SELECT * FROM status;");

    $status = $statusQuery->fetchAll();

} else if($method == "POST") {
    // Verificando tipo de POST
    $type = $_POST["type"];

    //Deletar pedido
    if($type === "delete") {

        $sorveteId = $_POST["id"];
  
        $deleteQuery = $conn->prepare("DELETE FROM pedidos WHERE sorvete_id = :sorvete_id;");
  
        $deleteQuery->bindParam(":sorvete_id", $sorveteId, PDO::PARAM_INT);
  
        $deleteQuery->execute();
  
        $_SESSION["msg"] = "Pedido removido com sucesso!";
        $_SESSION["status"] = "success";

        //Atualizar status do pedido
    } else if ($type === "update") {
        
        $sorveteId = $_POST["id"];
        $statusId = $_POST["status"];

        $updateQuery = $conn->prepare("UPDATE pedidos SET status_id = :status_id WHERE sorvete_id = :sorvete_id");

        $updateQuery->bindParam(":sorvete_id", $sorveteId, PDO::PARAM_INT);
        $updateQuery->bindParam(":status_id", $statusId, PDO::PARAM_INT);

        $updateQuery->execute();

        $_SESSION["msg"] = "Pedido atualizado com sucesso!";
        $_SESSION["status"] = "success";

    }

     // Retorna usuário para dashboard
     header("Location: ../dashboard.php");

}

?>