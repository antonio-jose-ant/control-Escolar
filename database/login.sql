-- sessions
CREATE TABLE sessions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    token_hash CHAR(64) NOT NULL,
    ip VARCHAR(45) NOT NULL,
    user_agent VARCHAR(255),
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    expires_at DATETIME,
    logged_in BOOLEAN,
    last_activity DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL,
    UNIQUE KEY unq_token_hash (token_hash),
    INDEX idx_user_token (user_id, token_hash),
    FOREIGN KEY (user_id) REFERENCES users (id) ON DELETE CASCADE
);

CREATE TABLE login_attempts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario VARCHAR(100) NULL,
    ip VARCHAR(45) NOT NULL,
    user_agent TEXT,
    fecha DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    resultado ENUM(
        'success',
        'fail',
        'blocked',
        'blacklisted',
        'temporarily_blocked'
    ) NOT NULL,
    razon_fallo VARCHAR(255) NULL
) ENGINE = InnoDB;

CREATE TABLE IP_INFOCLIENT (
    id INT AUTO_INCREMENT PRIMARY KEY,
    ip VARCHAR(45) NOT NULL UNIQUE INDEX,
    fecha DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    user_agent TEXT,
    country VARCHAR(255) NULL,
    region VARCHAR(255) NULL,
    city VARCHAR(255) NULL,
    latitude DECIMAL(10, 6) NULL,
    longitude DECIMAL(10, 6) NULL,
    INDEX idx_ip (ip)
)

CREATE TABLE IP_BLOCKED (
    IP VARCHAR(45) NOT NULL PRIMARY KEY,
    fecha_inicio DATETIME NOT NULL,
    fecha_fin DATETIME NOT NULL,
    motivo VARCHAR(255) NULL
);

CREATE TABLE IP_BLACKLIST (
    id INT AUTO_INCREMENT PRIMARY KEY,
    ip VARCHAR(45) NOT NULL UNIQUE,
    fecha DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    motivo VARCHAR(255) NULL
);

CREATE TABLE IP_TEMPORARILY_BLOCKED (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user VARCHAR(45) NOT NULL,
    ip VARCHAR(45) NOT NULL,
    fecha_inicio DATETIME NOT NULL,
    fecha_fin DATETIME NOT NULL
);