<?php

    $querySelUsl = $db->query("SELECT * FROM usluge");
    $statementSelUsl = $db->prepare($query);
    $statementSelUsl->execute();
    $arraySelUsl = $statement->fetchAll();
    $statementSelUsl->closeCursor();


function insertUsluge($nazivUsl){
    global $db;
    $count = 0;
    $query = "INSERT INTO usluge (naziv_usluge) VALUES (:nazivUsl)";
    $statement = $db->prepare($query);
    $statement->bindValue(":nazivUsl", $nazivUsl);
    if ($statement->execute()) {
        $count = $statement->rowCount();
    };
    $statement->closeCursor();

    return $count;
};

function updateUsluge($idUsl,$nazivUsl){
    global $db;
    $count = 0;
    $query = ("UPDATE usluge 
    SET naziv_usluge = :nazivUsl
    WHERE idUsluge = :idUsl ");
    $statement = $db->prepare($query);
    $statement->bindValue(':nazivUsl', $nazivUsl);
    $statement->bindValue(':idUsl', $idUsl);
    if ($statement->execute()) {
        $count = $statement->rowCount();
    };
    $statement->closeCursor();
    return $count;
};

function deleteUsluge($idUsl){
    global $db;
    $count = 0;
        $query = "DELETE FROM usluge 
                WHERE idUsluge = idUsl ";
        $statement = $db->prepare($query);
        $statement->bindValue(':idUsl', $idUsl);
        if ($statement->execute()) {
            $count = $statement->rowCount();
        };
        $statement->closeCursor();
        return $count;
    };