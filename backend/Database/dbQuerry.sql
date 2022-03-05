CREATE TABLE predavaci(
   idPredavac int(11) NOT NULL AUTO_INCREMENT,
   ime varchar(50),
   prezime varchar(50),
   PRIMARY KEY (idPredavac)
);

CREATE TABLE ustanove(
    idUstanove int(11) NOT NULL AUTO_INCREMENT,
    naziv_ustanove varchar(50),
    drzava varchar(50),
    mjesto varchar(50),
    PRIMARY KEY (idUstanove)
);

CREATE TABLE zaposlenje(
    idZaposlenje int(11) NOT NULL AUTO_INCREMENT,
    ustanova int(11) NOT NULL references ustanove(idUstanove),
    predavac int(11) NOT NULL references predavaci(idPredavac),
    PRIMARY KEY (idZaposlenje)
);

CREATE TABLE predavanja(
    idPredavanja int(11) NOT NULL AUTO_INCREMENT,
    naziv_predavanja varchar(50),
    predavac int REFERENCES predavaci(idPredavac),
    jezik varchar(50),
    godina varchar(50),
    broj_predavanja int(11),
    ukupno_trajanje int(11),
    oznaka varchar(50),
    opis_kolegija text,
    PRIMARY KEY (idPredavanja)
);

CREATE TABLE kategorije  (
    idKategorije int(11) NOT NULL AUTO_INCREMENT,
    naziv_kategorije varchar(50),
    PRIMARY KEY (idKategorije)
); 

CREATE TABLE pripadnost_kategoriji (
    idPripadnost_kategoriji int(11) NOT NULL AUTO_INCREMENT,
    predavanje int(11) NOT NULL references predavanja(idPredavanja),
    kategorije int(11) NOT NULL references kategorije(idKategorije),
    PRIMARY KEY (idPripadnost_kategoriji)
);


