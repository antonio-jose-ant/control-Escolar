
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
    resultado ENUM('success', 'fail') NOT NULL,
    razon_fallo VARCHAR(255) NULL
) ENGINE = InnoDB;