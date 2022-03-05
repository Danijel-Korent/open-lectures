CREATE TABLE administratori  (
  idAdmin int(11) NOT NULL AUTO_INCREMENT,
  ime_admina varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  prezime_admina varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  korisnicko_ime varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  lozinka varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  PRIMARY KEY (idAdmin) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 13 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;


CREATE TABLE pruzatelji(
    idPruz int NOT NULL AUTO_INCREMENT,
    naziv_pruzatelja varchar(50),
    email varchar(50),
    adresa varchar(50),
    kontakt varchar(50),
    URL_stranice varchar(50),
    radno_vrijeme varchar(50),
    napomena varchar(50000),
    longitude varchar(50),
    latitude varchar(50),
    PRIMARY KEY (idPruz)
);

CREATE TABLE usluge(
    idUsluge int NOT NULL AUTO_INCREMENT,
    naziv_usluge varchar(10000),
    PRIMARY KEY (idUsluge)
);

CREATE TABLE kategorije(
    idKategorija int NOT NULL AUTO_INCREMENT,
    naziv_kategorije varchar(10000),
    PRIMARY KEY (idKategorija)
);

CREATE TABLE pruzatelji_usluge(
    idPruzUsl int NOT NULL AUTO_INCREMENT,
    pruzatelj int REFERENCES pruzatelji(idPruz),
    usluga int REFERENCES usluge(idUsluga),
    PRIMARY KEY (idPruzUsl)
);

CREATE TABLE pruzatelji_usluge_kategorije(
    idPruzUslKat int NOT NULL AUTO_INCREMENT,
    pruzatelj_usluga int REFERENCES pruzatelji_usluge(idPruzUsl),
    kategorija int REFERENCES kategorije(idKategorija),
    PRIMARY KEY (idPruzUslKat)
);