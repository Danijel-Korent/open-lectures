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
    $query = ("SELECT pred.name, u.name,
    p.firstName, p.lastName,  pred.language, pred.n_lectures, 
    pred.t_duration, pred.course_code, pred.course_code, pred.description, pred.link_1, pred.link_2, pred.image, prip.kategorije, z.ustanova
    FROM ustanove u 
    INNER JOIN zaposlenje z ON u.id = z.ustanova
    INNER JOIN predavaci p ON p.id = z.predavac
    INNER JOIN lekcije l on l.predavac = p.id
    INNER JOIN predavanja pred ON pred.id = l.predavanja
    INNER JOIN pripadnost_kategoriji prip ON pred.id = prip.predavanje
    INNER JOIN kategorije k ON k.id = prip.kategorije;
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
    LEFT JOIN zaposlenje z ON u.id = z.ustanova
    LEFT JOIN predavaci p ON p.id = z.predavac
    LEFT JOIN lekcije l on l.predavac = p.id
    LEFT JOIN predavanja pred ON pred.id = l.predavanja
    LEFT JOIN pripadnost_kategoriji prip ON pred.id = prip.predavanje
    LEFT JOIN kategorije k ON k.id = prip.kategorije;
    ");
    $statement = $db->prepare($query);
    $statement->execute();
    $array = $statement->fetchAll();
    $statement->closeCursor();

    return $array;
};


