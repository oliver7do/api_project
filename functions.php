<?php

function dbConnect()
{
    $conn = null;

    try {
        $conn = new PDO("mysql:host=localhost;dbname=api_rest", "root", "");
    } catch (PDOException $error) {
        $conn = $error->getMessage();
    }
    return $conn;
}

function produits($nom, $description, $prix, $categorie_id)
{
    // connexion base de données :
    $db = dbConnect();

    // Préparer la requête :
    $request = $db->prepare("INSERT INTO produits (nom,description,prix,categories_id) VALUES (?,?,?,?)");

    // Executer la requête :
    try {
        $request->execute(array($nom, $description, $prix, $categorie_id));
        echo  json_encode([
            "status" => 200,
            "message" => "Produit envoyé avec succès"
        ]);
    } catch (PDOException $error) {
        echo json_encode([
            "status" => 500,
            "message" => "Produit non envoyé",
            "error" => $error
        ]);
    }
}

function findAll()
{
    $db = dbConnect();

    // Préparer la requête
    $request = $db->prepare('SELECT * FROM produits');

    // Execution de la requête
    try{
        $request->execute();
        $produits = $request->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode([
            "status" => 200,
            "message" => "Voici la liste des produits disponibles",
            "data" => $produits
        ]);
       } catch (PDOException $e) {
        echo json_encode([
            "status" => 1000,
            "message" => "Karima a encorre fait des siennes !",
            "error" => $e
        ]);
    }
}
