-- =========================
-- MODULOS
-- =========================

CREATE TABLE modules (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(150) NOT NULL UNIQUE
);

-- =========================
-- OPCIONES DE MODULOS
-- =========================

CREATE TABLE module_options (
    id INT AUTO_INCREMENT PRIMARY KEY,
    module_id INT NOT NULL,
    name VARCHAR(150) NOT NULL,
    FOREIGN KEY (module_id) REFERENCES modules (id) ON DELETE CASCADE
);

-- =========================
-- PERMISOS
-- =========================

CREATE TABLE permissions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL UNIQUE
);

-- Ejemplos:
-- view
-- create
-- update
-- delete
-- export
-- approve

-- =========================
-- PERMISOS POR ROL
-- =========================

CREATE TABLE role_permissions (
    role_id INT NOT NULL,
    option_id INT NOT NULL,
    permission_id INT NOT NULL,
    PRIMARY KEY (
        role_id,
        option_id,
        permission_id
    ),
    FOREIGN KEY (role_id) REFERENCES roles (id) ON DELETE CASCADE,
    FOREIGN KEY (option_id) REFERENCES module_options (id) ON DELETE CASCADE,
    FOREIGN KEY (permission_id) REFERENCES permissions (id) ON DELETE CASCADE
);

-- =========================
-- EXCEPCIONES POR USUARIO
-- =========================

CREATE TABLE user_permissions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    option_id INT NOT NULL,
    permission_id INT NOT NULL,
    effect ENUM('allow', 'deny') NOT NULL,
    granted_by INT,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    is_active BOOLEAN,
    PRIMARY KEY (
        user_id,
        option_id,
        permission_id
    ),
    FOREIGN KEY (user_id) REFERENCES users (id) ON DELETE CASCADE,
    FOREIGN KEY (option_id) REFERENCES module_options (id) ON DELETE CASCADE,
    FOREIGN KEY (permission_id) REFERENCES permissions (id) ON DELETE CASCADE,
    FOREIGN KEY (granted_by) REFERENCES users (id) ON DELETE SET NULL,
    FOREIGN KEY (update_by) REFERENCES users (id) ON DELETE SET NULL
);

create table user_permissions_kardex (
    id int AUTO_INCREMENT PRIMARY KEY,
    id_user_permissions int,
    update_by INT,
    action ENUM(
        'create',
        'activate',
        'deactivate',
        'update'
    ) NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_user_permissions) REFERENCES user_permissions (id),
    FOREIGN KEY (update_by) REFERENCES users (id),
)

-- =========================
-- MODULOS EXTRA POR USUARIO
-- =========================

CREATE TABLE user_modules (
    user_id INT NOT NULL,
    module_id INT NOT NULL,
    access ENUM('allow', 'deny') NOT NULL,
    granted_by INT,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (user_id, module_id),
    FOREIGN KEY (user_id) REFERENCES users (id) ON DELETE CASCADE,
    FOREIGN KEY (module_id) REFERENCES modules (id) ON DELETE CASCADE,
    FOREIGN KEY (granted_by) REFERENCES users (id) ON DELETE SET NULL
);

create table user_modules_permissions_kardex (
    id int AUTO_INCREMENT PRIMARY KEY,
    id_user_modules int,
    update_by INT,
    action ENUM(
        'create',
        'activate',
        'deactivate',
        'update'
    ) NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_user_modules) REFERENCES user_modules (id),
    FOREIGN KEY (update_by) REFERENCES users (id),
)