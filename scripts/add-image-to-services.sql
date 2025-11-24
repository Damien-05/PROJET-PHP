-- Ajouter une colonne image à la table services
ALTER TABLE services 
ADD COLUMN image VARCHAR(255) DEFAULT NULL AFTER description;
