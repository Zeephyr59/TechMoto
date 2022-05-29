
/*
    Ajout d'une moto et de tous ces informations complémentaires

    - Création de la 'marque' si nouvelle
    - Création du 'type' si nouveau 
    - Création du 'technical_profil'
    - Création de la 'moto'
    - Création des lignes 'option'
*/

--
-- Création du 'technical_profil
-- cylindre, moteur, puissance,	couple,	démarrage	
--
INSERT INTO `technical_profil` (`cylindre`, `moteur`, `puissance`, `couple`, `démarrage`) VALUES 
('471', 'Bicylindre 4 temps, double ACT et 4 soupapes par cylindre, refroidi par eau', '35 kW à 8 600 tr/min (95/1/EC)', '35 kW à 8 600 tr/min (95/1/EC)', 'Électrique');

--
-- Insertion d'une ligne 'moto'
-- name, slug, released_in, price, slogan, accroche, banner, thumbnail, picture, technical_profil_id, marque_id, type_id
--

INSERT INTO `moto` (`name`, `slug`, `released_in`, `price`, `slogan`, `accroche`, `banner`, `thumbnail`, `picture`, `technical_profil_id`, `marque_id`, `type_id`) VALUES 
('CB500F', 'cb500f', '2022-01-03', '6799', 'Libérez le motard qui est en vous', 'Une bicylindre puissante et extrêmement agréable', 'Honda_banner_3.jpg', 'Honda_thumbnail_3.jpg', 'Honda_picture_3.jpg', '5', '1', '1');

--
-- Insertion des lignes 'option'
-- name, description, picture, moto_id
--

INSERT INTO `option` (`name`, `description`, `picture`, `moto_id`) VALUES 
('Un moteur bicylindre puissant et agréable', 
'Qu'il s'agisse de votre première moto (ou de la dernière en date), le moteur compatible avec le permis A2 offre un couple puissant à mi-régime et énergique à haut régime.', 
'Z900_option_2.jpg', '5');

INSERT INTO `option` (`name`, `description`, `picture`, `moto_id`) VALUES 
('Tableau de bord LCD', 
'La superbe instrumentation LCD avec rétro-éclairage personnalisable affiche clairement les informations et propose des indicateurs personnalisables de position et de changement de vitesse.', 
'Honda_option_1.jpg', '5');

INSERT INTO `option` (`name`, `description`, `picture`, `moto_id`) VALUES 
('Nouvelles roues et bras oscillant allégés', 
'Le bras oscillant allégé et les nouvelles roues à 5 branches réduisent la masse non suspendue, ce qui permet une direction plus réactive.', 
'Honda_option_2.jpg', '5');