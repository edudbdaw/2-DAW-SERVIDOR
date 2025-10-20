CREATE TABLE juegos (
    id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id INT(11) UNSIGNED NOT NULL, -- Clave foránea
    
    titulo VARCHAR(255) NOT NULL,
    descripcion TEXT NOT NULL,
    autor VARCHAR(100) NOT NULL, 
    caratula_path VARCHAR(255) NULL, 
    categoria VARCHAR(50) NOT NULL, 
    url VARCHAR(255) NULL, 
    year_juego YEAR NOT NULL, 
    
    -- Definición de la Clave Foránea
    CONSTRAINT fk_user
        FOREIGN KEY (user_id) 
        REFERENCES usuarios(id)
        ON DELETE CASCADE -- Si se borra el usuario, se borran sus juegos.
);