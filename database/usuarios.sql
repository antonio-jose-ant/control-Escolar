CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(255) UNIQUE NOT NULL,
    password_hash VARCHAR(255) NOT NULL,
    is_active TINYINT(1) NOT NULL DEFAULT 1,
    nombre VARCHAR(256) NOT NULL,
    apellido_p VARCHAR(256) NOT NULL,
    apellido_M VARCHAR(256) NOT NULL,
    numero VARCHAR(20),
    sexo ENUM('M', 'F'),
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    granted_by int
);

CREATE TABLE INFO_CONTACTO_USER (
    id int AUTO_INCREMENT PRIMARY Key,
    medio VARCHAR(150),
    datos set('admin', 'master', 'control'),
    Pertenece VARCHAR(150),
    Foreign Key (id) REFERENCES users (id)
);

CREATE Table DIRECCION_USER (
    id int AUTO_INCREMENT PRIMARY Key,
    id_user int,
    type_direccion VARCHAR(150) NOT NULL,
    cp VARCHAR(8),
    calle VARCHAR(120),
    no_int VARCHAR(30),
    no_ext VARCHAR(30),
    entre_calle_1 VARCHAR(120),
    entre_calle_2 VARCHAR(120),
    colonia VARCHAR(120),
    estado VARCHAR(200),
    monicipio varchar(120),
    Foreign Key (id) REFERENCES users (id)
)
CREATE TABLE roles (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(50) UNIQUE
);

CREATE TABLE user_roles (
    user_id INT,
    role_id INT,
    PRIMARY KEY (user_id, role_id),
    FOREIGN KEY (user_id) REFERENCES users (id),
    FOREIGN KEY (role_id) REFERENCES roles (id)
);