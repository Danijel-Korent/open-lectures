<?php
function selectUstanove(){
    global $db;
    $query = ("SELECT *
    FROM ustanove;");
    $statement = $db->prepare($query);
    $statement->execute();
    $array = $statement->fetchAll();
    $statement->closeCursor();

    return $array;
};

function selectKategorije(){
    global $db;
    $query = ("SELECT * FROM kategorije;");
    $statement = $db->prepare($query);
    $statement->execute();
    $array = $statement->fetchAll();
    $statement->closeCursor();

    return $array;
};

function selectPredavaci(){
    global $db;
    $query = ("SELECT *
    FROM predavaci;");
    $statement = $db->prepare($query);
    $statement->execute();
    $array = $statement->fetchAll();
    $statement->closeCursor();

    return $array;
};

function selectOpisPred (){
    global $db;
    $query = ("SELECT pred.naziv_predavanja, u.naziv_ustanove,
    p.ime, p.prezime,  pred.jezik, pred.broj_predavanja, 
    pred.ukupno_trajanje, pred.oznaka, pred.oznaka, pred.opis_kolegija, pred.link_1, pred.link_2, pred.image, prip.kategorije, z.ustanova
    FROM ustanove u 
    INNER JOIN zaposlenje z ON u.idUstanove = z.ustanova
    INNER JOIN predavaci p ON p.idPredavac = z.predavac
    INNER JOIN lekcije l on l.predavac = p.idPredavac
    INNER JOIN predavanja pred ON pred.idPredavanja = l.predavanja
    INNER JOIN pripadnost_kategoriji prip ON pred.idPredavanja = prip.predavanje
    INNER JOIN kategorije k ON k.idKategorije = prip.kategorije;
    ");
    $statement = $db->prepare($query);
    $statement->execute();
    $array = $statement->fetchAll();
    $statement->closeCursor();

    return $array;
};

function selectAll(){
    global $db;
    $query = ("SELECT *
    FROM ustanove u 
    LEFT JOIN zaposlenje z ON u.idUstanove = z.ustanova
    LEFT JOIN predavaci p ON p.idPredavac = z.predavac
    LEFT JOIN lekcije l on l.predavac = p.idPredavac
    LEFT JOIN predavanja pred ON pred.idPredavanja = l.predavanja
    LEFT JOIN pripadnost_kategoriji prip ON pred.idPredavanja = prip.predavanje
    LEFT JOIN kategorije k ON k.idKategorije = prip.kategorije;
    ");
    $statement = $db->prepare($query);
    $statement->execute();
    $array = $statement->fetchAll();
    $statement->closeCursor();

    return $array;
};


