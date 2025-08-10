CREATE TABLE IF NOT EXISTS scheduled_tasks (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    script_path VARCHAR(255) NOT NULL,
    interval_type ENUM('minute', 'hour', 'day', 'custom') NOT NULL,
    interval_value INT NOT NULL,
    last_run DATETIME DEFAULT NULL,
    run_count INT DEFAULT 0,
    is_active TINYINT(1) DEFAULT 1
); 