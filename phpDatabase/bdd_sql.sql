DROP DATABASE doctobobo;

CREATE SCHEMA IF NOT EXISTS `doctobobo` DEFAULT CHARACTER SET utf8 ;
USE `doctobobo` ;

-- -----------------------------------------------------
-- Table `doctobobo`.`Prescription`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `doctobobo`.`Prescription` (
  `idPrescription` INT NOT NULL AUTO_INCREMENT,
  `NbrJours` INT NOT NULL,
  `Medicaments` VARCHAR(500) NOT NULL,
  PRIMARY KEY (`idPrescription`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `doctobobo`.`Medecin`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `doctobobo`.`Medecin` (
  `idMedecin` INT NOT NULL AUTO_INCREMENT,
  `Nom_Medecin` VARCHAR(200) NOT NULL,
  `Prenom_Medecin` VARCHAR(200) NOT NULL,
  `DateNaissance` DATE NOT NULL,
  `Specialite` VARCHAR(100) NULL,
  `email` VARCHAR(200) NOT NULL,
  `password` VARCHAR(200) NOT NULL,
  `adresse` VARCHAR(100) NOT NULL,
  `code_postal` VARCHAR(100) NOT NULL,
  `description` VARCHAR(1000) NOT NULL,
  PRIMARY KEY (`idMedecin`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `doctobobo`.`Patient`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `doctobobo`.`Patient` (
  `idPatient` INT NOT NULL AUTO_INCREMENT,
  `Nom_Patient` VARCHAR(45) NOT NULL,
  `Prenom_Patient` VARCHAR(45) NOT NULL,
  `DateNaissance` DATE NOT NULL,
  `email` VARCHAR(200) NOT NULL,
  `password` VARCHAR(100) NOT NULL,
  `adresse` VARCHAR(100) NOT NULL,
  `code_postal` VARCHAR(100) NOT NULL,
  PRIMARY KEY (`idPatient`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `doctobobo`.`Consultation`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `doctobobo`.`Consultation` (
  `idConsultation` INT NOT NULL AUTO_INCREMENT,
  `DateHeure` DATETIME NOT NULL,
  `Patient_idPatient` INT NOT NULL,
  `motif` VARCHAR(300) NULL,
  `description` VARCHAR(300) NULL,
  `Prescription_idPrescription` INT NULL,
  `Medecin_idMedecin` INT NOT NULL,
  PRIMARY KEY (`idConsultation`),
  INDEX `fk_Consultation_Patient1_idx` (`Patient_idPatient` ASC) VISIBLE,
  INDEX `fk_Consultation_Prescription1_idx` (`Prescription_idPrescription` ASC) VISIBLE,
  INDEX `fk_Consultation_Medecin1_idx` (`Medecin_idMedecin` ASC) VISIBLE,
  CONSTRAINT `fk_Consultation_Patient1`
    FOREIGN KEY (`Patient_idPatient`)
    REFERENCES `doctobobo`.`Patient` (`idPatient`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Consultation_Prescription1`
    FOREIGN KEY (`Prescription_idPrescription`)
    REFERENCES `doctobobo`.`Prescription` (`idPrescription`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Consultation_Medecin1`
    FOREIGN KEY (`Medecin_idMedecin`)
    REFERENCES `doctobobo`.`Medecin` (`idMedecin`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

INSERT INTO Prescription (NbrJours, Medicaments) VALUES
(7, 'Paracétamol 500mg, 1 comprimé toutes les 6 heures'),
(5, 'Amoxicilline 500mg, 1 comprimé toutes les 8 heures'),
(3, 'Ibuprofène 200mg, 1 comprimé toutes les 4 heures'),
(10, 'Ciprofloxacine 500mg, 1 comprimé toutes les 12 heures'),
(14, 'Azithromycine 250mg, 1 comprimé par jour'),
(5, 'Lévofloxacine 500mg, 1 comprimé par jour'),
(7, 'Diclofénac 50mg, 1 comprimé toutes les 8 heures'),
(30, 'Atorvastatine 20mg, 1 comprimé par jour'),
(7, 'Hydrochlorothiazide 25mg, 1 comprimé par jour'),
(5, 'Prednisolone 5mg, 1 comprimé par jour'),
(10, 'Metformine 500mg, 1 comprimé deux fois par jour'),
(7, 'Omeprazole 20mg, 1 comprimé par jour'),
(30, 'Lisinopril 10mg, 1 comprimé par jour'),
(14, 'Losartan 50mg, 1 comprimé par jour'),
(7, 'Metoprolol 25mg, 1 comprimé deux fois par jour'),
(5, 'Amlodipine 5mg, 1 comprimé par jour'),
(30, 'Simvastatine 20mg, 1 comprimé par jour'),
(14, 'Rosuvastatine 10mg, 1 comprimé par jour'),
(7, 'Pravastatine 40mg, 1 comprimé par jour'),
(30, 'Furosemide 40mg, 1 comprimé par jour');


-- Insérer des données dans la table Patient
INSERT INTO `doctobobo`.`Patient` (Nom_Patient, Prenom_Patient, DateNaissance, email, password, adresse, code_postal) VALUES 
('Martin', 'Pierre', '1985-11-02', 'pierre.martin@email.com', MD5('password123'), '12 rue des Fleurs', '75001'),
('Dupont', 'Marie', '1989-08-15', 'marie.dupont@email.com', MD5('password123'), '15 rue de la Paix', '75002'),
('Leroy', 'Jean', '1992-05-03', 'jean.leroy@email.com', MD5('password123'), '18 avenue des Champs-Élysées', '75008'),
('Rousseau', 'Claire', '1978-02-26', 'claire.rousseau@email.com', MD5('password123'), '25 boulevard Saint-Michel', '75005'),
('Moreau', 'Julien', '1990-10-14', 'julien.moreau@email.com', MD5('password123'), '35 rue de Rivoli', '75004'),
('Simon', 'Caroline', '1995-01-29', 'caroline.simon@email.com', MD5('password123'), '40 rue de la Pompe', '75016'),
('Lefevre', 'Louis', '1982-12-11', 'louis.lefevre@email.com', MD5('password123'), '22 rue du Commerce', '75015'),
('Laurent', 'Sophie', '1994-04-07', 'sophie.laurent@email.com', MD5('password123'), '8 avenue des Ternes', '75017'),
('Fournier', 'David', '1981-07-13', 'david.fournier@email.com', MD5('password123'), '19 rue de l’Échiquier', '75010'),
('Roussel', 'Eva', '1987-09-24', 'eva.roussel@email.com', MD5('password123'), '47 rue de la Chapelle', '75018'),
('Garnier', 'Lucas', '1991-06-30', 'lucas.garnier@email.com', MD5('password123'), '52 boulevard de la Villette', '75019'),
('Dumont', 'Lea', '1993-03-18', 'lea.dumont@email.com', MD5('password123'), '33 rue de la Roquette', '75011'),
('Bertrand', 'Philippe', '1979-11-09', 'philippe.bertrand@email.com', MD5('password123'), '37 rue du Faubourg Saint-Antoine', '75012'),
('Guillaume', 'Catherine', '1984-08-21', 'catherine.guillaume@email.com', MD5('password123'), '42 rue de la Gare', '75013'),
('Leger', 'Arnaud', '1997-05-05', 'arnaud.leger@email.com', MD5('password123'), '15 rue des Écoles', '75005'),
('Mercier', 'Elodie', '1983-02-27', 'elodie.mercier@email.com', MD5('password123'), '29 rue des Francs-Bourgeois', '75003'),
('Boucher', 'Valentin', '1996-12-12', 'valentin.boucher@email.com', MD5('password123'), '56 rue de la Santé', '75014'),
('Clement', 'Juliette', '1998-04-08', 'juliette.clement@email.com', MD5('password123'), '61 rue de la Gaîté', '75006'),
('Riviere', 'Isabelle', '1980-07-14', 'isabelle.riviere@email.com', MD5('password123'), '66 rue des Dames', '75017'),
('Poirier', 'Vincent', '1977-09-25', 'vincent.poirier@email.com', MD5('password123'), '5 rue de Montmorency', '75003');




-- Insérer des données dans la table Patient
INSERT INTO `doctobobo`.`Medecin` (Nom_Medecin, Prenom_Medecin, DateNaissance, Specialite, email, password, adresse, code_postal) VALUES 
('Durand', 'Mathieu', '1965-05-17', 'Gastro-entérologue', 'mathieu.durand@email.com', MD5('password123'), '32 rue de la Pompe', '75016'),
('Leroy', 'Camille', '1983-08-26', 'Dermatologue', 'camille.leroy@email.com', MD5('password123'), '27 rue Oberkampf', '75011'),
('Marchand', 'Marie', '1978-02-15', 'Pédiatre', 'marie.marchand@email.com', MD5('password123'), '11 rue de la Roquette', '75011'),
('Moreau', 'Paul', '1972-01-30', 'Orthopédiste', 'paul.moreau@email.com', MD5('password123'), '18 rue des Pyramides', '75001'),
('Roux', 'Nathalie', '1969-11-13', 'Endocrinologue', 'nathalie.roux@email.com', MD5('password123'), '6 rue de l\'Étoile', '75017'),
('Dumont', 'Thierry', '1982-06-21', 'Neurologue', 'thierry.dumont@email.com', MD5('password123'), '13 rue de l\'Échiquier', '75010'),
('Fournier', 'Céline', '1981-10-19', 'Ophtalmologue', 'celine.fournier@email.com', MD5('password123'), '22 rue des Jeûneurs', '75002'),
('David', 'Guillaume', '1966-07-02', 'Oncologue', 'guillaume.david@email.com', MD5('password123'), '9 rue de la Chaussée d\'Antin', '75009'),
('Thomas', 'Mélanie', '1975-04-29', 'Rhumatologue', 'melanie.thomas@email.com', MD5('password123'), '16 rue de Turenne', '75004'),
('Lacroix', 'Olivier', '1979-12-03', 'Urologue', 'olivier.lacroix@email.com', MD5('password123'), '31 rue de Turbigo', '75003'),
('Boucher', 'Alice', '1985-09-25', 'Radiologue', 'alice.boucher@email.com', MD5('password123'), '44 rue de Dunkerque', '75010'),
('Blanchard', 'Lucas', '1976-03-14', 'Néphrologue', 'lucas.blanchard@email.com', MD5('password123'), '2 rue de Bellechasse', '75007'),
('Bourgeois', 'Elodie', '1984-07-09', 'Gynécologue', 'elodie.bourgeois@email.com', MD5('password123'), '58 rue de la Convention', '75015'),
('Bonnet', 'Romain', '1967-08-28', 'Pneumologue', 'romain.bonnet@email.com', MD5('password123'), '9 rue de Cléry', '75002'),
('Leclerc', 'Amélie', '1980-05-15', 'Allergologue', 'amelie.leclerc@email.com', MD5('password123'), '7 rue de la Chapelle', '75018'),
('Gauthier', 'Yann', '1962-10-31', 'Hématologue', 'yann.gauthier@email.com', MD5('password123'), '12 rue Réaumur', '75003'),
('Richer', 'Aurélie', '1974-06-07', 'Infectiologue', 'aurelie.richer@email.com', MD5('password123'), '3 rue de Paradis', '75010'),
('Vidal', 'Martin', '1987-01-04', 'Oto-rhino-laryngologiste', 'martin.vidal@email.com', MD5('password123'), '6 rue de la Victoire', '75009'),
('Denis', 'Catherine', '1964-04-23', 'Gériatre', 'catherine.denis@email.com', MD5('password123'), '38 rue de l\'Échelle', '75001'),
('Guillot', 'Benoît', '1973-11-12', 'Psychiatre', 'benoit.guillot@email.com', MD5('password123'), '5 rue de la Folie-Méricourt', '75011');



-- Insérer des données dans la table Consultation
INSERT INTO Consultation (DateHeure, Patient_idPatient, motif, description, Prescription_idPrescription, Medecin_idMedecin) VALUES
('2023-04-01 09:00:00', 1, 'Fièvre et douleurs', 'Patient souffrant de fièvre et de douleurs musculaires', 1, 1),
('2023-04-01 10:00:00', 2, 'Toux et mal de gorge', 'Patient souffrant de toux et de mal de gorge', 2, 1),
('2023-04-01 11:00:00', 3, 'Migraine', 'Patient souffrant de migraine', 3, 1),
('2023-04-01 14:00:00', 4, 'Infection urinaire', 'Patient souffrant d''infection urinaire', 4, 1),
('2023-04-01 15:00:00', 5, 'Infection pulmonaire', 'Patient souffrant d''infection pulmonaire', 5, 2),
('2023-04-01 16:00:00', 6, 'Infection cutanée', 'Patient souffrant d''infection cutanée', 6, 3),
('2023-04-01 17:00:00', 7, 'Douleurs articulaires', 'Patient souffrant de douleurs articulaires', 7, 4),
('2023-04-02 09:00:00', 8, 'Hypertension', 'Patient souffrant d''hypertension', 8, 5),
('2023-04-02 10:00:00', 9, 'Insuffisance cardiaque', 'Patient souffrant d''insuffisance cardiaque', 9, 6),
('2023-04-02 11:00:00', 10, 'Asthme', 'Patient souffrant d''asthme', 10, 7),
('2023-04-02 14:00:00', 11, 'Diabète', 'Patient souffrant de diabète', 11, 8),
('2023-04-02 15:00:00', 12, 'Reflux gastro-oesophagien', 'Patient souffrant de reflux gastro-oesophagien', 12, 9),
('2023-04-02 16:00:00', 13, 'Angine de poitrine', 'Patient souffrant d''angine de poitrine', 13, 10),
('2023-04-02 17:00:00', 14, 'Arthrose', 'Patient souffrant d''arthrose', 14, 11),
('2023-04-03 09:00:00', 15, 'Hypercholestérolémie', 'Patient souffrant d''hypercholestérolémie', 15, 12),
('2023-04-03 10:00:00', 16, 'Hypothyroïdie', 'Patient souffrant d''hypothyroïdie', 16, 13),
('2023-04-03 11:00:00', 17, 'Maladie rénale chronique', 'Patient souffrant de maladie rénale chronique', 17, 14),
('2023-04-03 14:00:00', 18, 'Prostatite', 'Patient souffrant de prostatite', 18, 15),
('2023-04-03 15:00:00', 19, 'Cancer du sein', 'Patient souffrant de cancer du sein', 19, 16),
('2023-04-03 16:00:00', 20, 'Dépression', 'Patient souffrant de dépression', 20, 17);


