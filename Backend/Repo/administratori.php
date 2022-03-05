<?php

    $querySelAdm = ("SELECT * FROM administratori");
    $statementSelAdm = $db->prepare($querySelAdm);
    $statementSelAdm->execute();
    $arraySelAdm = $statementSelAdm->fetchAll();
    $statementSelAdm->closeCursor();

function insertAdministrator ($ime, $prezime, $username, $lozinka) {
    global $db;
    $count = 0;
    $query = 
    "INSERT INTO administratori (ime_admina, prezime_admina, korisnicko_ime, lozinka) 
    VALUES (:ime, :prezime, :username, :lozinka)";
    $statement = $db->prepare($query);
    $statement->bindValue(':ime', $ime);
    $statement->bindValue(':prezime', $prezime);
    $statement->bindValue(':username', $username);
    $statement->bindValue(':lozinka', $lozinka);
    if ($statement->execute()) {
        $count = $statement->rowCount();
    };
    $statement->closeCursor();

    return $count;
};

function updateAdministrator ($idAdmin, $ime, $prezime, $username, $lozinka){
    global $db;
    $count = 0;
    $query = ("UPDATE administratori SET 
    ime_admina = :ime,
    prezime_admina = :prezime,
    korisnicko_ime = :username, 
    lozinka = :lozinka, 
    WHERE idAdmin = :idAdmin ");
    $statement = $db->prepare($query);
    $statement->bindValue(':idAdmin', $idAdmin);
    $statement->bindValue(':ime', $ime);
    $statement->bindValue(':prezime', $prezime);
    $statement->bindValue(':username', $username);
    $statement->bindValue(':lozinka', $lozinka);
    if ($statement->execute()) {
        $count = $statement->rowCount();
    };
    $statement->closeCursor();
    return $count;
};

function deleteAdministrator($idAdmin){
    global $db;
    $count = 0;
        $query = "DELETE FROM administratori 
                WHERE idAdmin = :idAdmin ";
        $statement = $db->prepare($query);
        $statement->bindValue(':idAdmin', $idAdmin);
        if ($statement->execute()) {
            $count = $statement->rowCount();
        };
        $statement->closeCursor();
        return $count;
};        