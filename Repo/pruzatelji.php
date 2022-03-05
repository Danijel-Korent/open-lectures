<?php

function selectPruzatelji(){
    global $db;
    $query = $db->query("SELECT * FROM pruzatelji");
    $statement = $db->prepare($query);
    $statement->execute();
    $array = $statement->fetchAll();
    $statement->closeCursor();

    return $array;
};

function insertPruzatelj($nazivPruzatelja, $email, $adresa, $kontakt, $URL, $radnVr, $napomena, $long, $lat){
    global $db;
    $count = 0;
    $query = 
    "INSERT INTO 
    pruzatelji (naziv_pruzatelja, email, adresa, kontakt, URL_stranice, radno_vrijeme, napomena, longitude, latitude) 
    VALUES 
    (:nazivPruzatelja, :email, :adresa, :kontakt, :stranica, :radnVr, :napomena, :long, :lat)";
    $statement = $db->prepare($query);
    $statement->bindValue(':nazivPruzatelja', $nazivPruzatelja);
    $statement->bindValue(':email', $email);
    $statement->bindValue(':adresa', $adresa);
    $statement->bindValue(':kontakt', $kontakt);
    $statement->bindValue(':stranica', $URL);
    $statement->bindValue(':radnVr', $radnVr);
    $statement->bindValue(':napomena', $napomena);
    $statement->bindValue(':long', $long);
    $statement->bindValue(':lat', $lat);
    if ($statement->execute()) {
        $count = $statement->rowCount();
    };
    $statement->closeCursor();

    return $count;
};

function updatePruzatelj($idPruz, $nazivPruzatelja, $email, $adresa, $kontakt, $URL, $radnVr, $napomena, $long, $lat){
    global $db;
    $count = 0;
    $query = ("UPDATE pruzatelji 
    SET naziv_pruzatelja = :nazivPruzatelja,
    email = :email,
    adresa = :adresa,
    kontakt = :kontakt,
    URL_stranice = :stranica,
    radno_vrijeme = :radnVr,
    napomena = :napomena,
    longitude = :long,
    latitude = :lat,

    WHERE id = :idPruz ");
    $statement = $db->prepare($query);
    $statement->bindValue(':idPruz', $idPruz);
    $statement->bindValue(':nazivPruzatelja', $nazivPruzatelja);
    $statement->bindValue(':email', $email);
    $statement->bindValue(':adresa', $adresa);
    $statement->bindValue(':kontakt', $kontakt);
    $statement->bindValue(':stranica', $URL);
    $statement->bindValue(':radnVr', $radnVr);
    $statement->bindValue(':napomena', $napomena);
    $statement->bindValue(':long', $long);
    $statement->bindValue(':lat', $lat);
    if ($statement->execute()) {
        $count = $statement->rowCount();
    };
    $statement->closeCursor();
    return $count;
};

function deletePruzatelj($idPruz){
    global $db;
    $count = 0;
        $query = "DELETE FROM pruzatelji 
                WHERE idPruz = :idPruz ";
        $statement = $db->prepare($query);
        $statement->bindValue(':idPruz', $idPruz);
        if ($statement->execute()) {
            $count = $statement->rowCount();
        };
        $statement->closeCursor();
        return $count;
    };