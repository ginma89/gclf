CREATE TABLE support (
  sup_id INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  sup_nom VARCHAR(64) NULL,
  sup_created DATETIME NULL,
  sup_updated DATETIME NULL,
  PRIMARY KEY(sup_id)
);

CREATE TABLE categorie (
  cat_id INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  cat_nom VARCHAR(32) NULL,
  cat_created DATETIME NULL,
  cat_updated DATETIME NULL,
  PRIMARY KEY(cat_id)
);

CREATE TABLE film (
  fil_id INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  sup_id INTEGER UNSIGNED NOT NULL,
  cat_id INTEGER UNSIGNED NOT NULL,
  fil_titre VARCHAR(128) NULL,
  fil_filename VARCHAR(255) NULL,
  fil_annee SMALLINT UNSIGNED NULL,
  fil_affiche VARCHAR(255) NULL,
  fil_synopsis TEXT NULL,
  fil_acteurs TEXT NULL,
  fil_description TEXT NULL,
  fil_created DATETIME NULL,
  fil_updated DATETIME NULL,
  PRIMARY KEY(fil_id),
  INDEX film_FKIndex1(cat_id),
  INDEX film_FKIndex2(sup_id)
);


