<?php

include_once("conn.php");

$method = $_SERVER["REQUEST_METHOD"];

//Resgate dos dados, montagem do pedido
if ($method == "GET"){

    $coberturasQuery = $conn->query("SELECT * FROM coberturas;");

    $coberturas = $coberturasQuery->fetchAll();

    $guloseimasQuery = $conn->query("SELECT * FROM guloseimas;");

    $guloseimas = $guloseimasQuery->fetchAll();

    $saboresQuery = $conn->query("SELECT * FROM sabores;");

    $sabores = $saboresQuery->fetchAll();


// Criação dos pedidos
} else if($method == "POST"){

    $data = $_POST;

    $cobertura = $data["cobertura"];
    $guloseima = $data["guloseima"];
    $sabores = $data["sabores"];

    //Validação de sabores máximos

    if(count($sabores) > 3) {

        $_SESSION["msg"] = "Selecione no máximo 3 sabores!";
        $_SESSION["status"] = "warning";

    } else {

        //Salvando cobertura e guloseima no sorvete
        $stmt = $conn->prepare("INSERT INTO sorvetes (cobertura_id, guloseima_id) VALUES (:cobertura, :guloseima)");

        //Filtrando inputs
        $stmt->bindParam(":cobertura", $cobertura, PDO::PARAM_INT);
        $stmt->bindParam(":guloseima", $guloseima, PDO::PARAM_INT);

        $stmt->execute();

        // Resgatando último id da última pizza
        $sorveteId = $conn->lastInsertId();

        $stmt = $conn->prepare("INSERT INTO sorvete_sabor (sorvete_id, sabor_id) VALUES (:sorvete, :sabor)");

        // Repetição até terminar de salvar todos os sabores
        foreach($sabores as $sabor){

            //  Filtrando os inputs
            $stmt->bindParam(":sorvete", $sorveteId, PDO::PARAM_INT);
            $stmt->bindParam(":sabor", $sabor, PDO::PARAM_INT);  

            $stmt->execute();

        }

        //Criar o pedido do sorvete
        $stmt= $conn->prepare("INSERT INTO pedidos (sorvete_id, status_id) VALUES (:sorvete, :status)");

        //Status = Sempre inicia com 1(Em produção)
        $statusId = 1;

        //Filtrar inputs
        $stmt->bindParam(":sorvete", $sorveteId);
        $stmt->bindParam(":status", $statusId);

        $stmt->execute();

        //Exibir mensagem de sucess
        $_SESSION["msg"] = "Pedido realizado com sucesso";
        $_SESSION["status"] = "sucess";


    }

    //Retorna  para página incial
    header("Location: ..");
    
}

?>