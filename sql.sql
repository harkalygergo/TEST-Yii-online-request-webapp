CREATE DATABASE yii2basic CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

USE yii2basic;

CREATE TABLE requests (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    work_type ENUM('allapotfelmeres', 'alapozas_elokeszites', 'epitekzes', 'muszaki_ellenorzes') NOT NULL,
    work_details TEXT NOT NULL,
    ip_address VARCHAR(45),
    user_agent TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);
