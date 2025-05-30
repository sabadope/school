-- First, add the encryption column if it doesn't exist
ALTER TABLE users
ADD COLUMN IF NOT EXISTS encryption_enabled TINYINT(1) DEFAULT 1;

-- Create the encryption function if it doesn't exist
DELIMITER //
CREATE FUNCTION IF NOT EXISTS encrypt_data(data VARCHAR(255)) 
RETURNS VARCHAR(255)
DETERMINISTIC
BEGIN
    RETURN SHA2(data, 256);
END //

-- Create the check function if it doesn't exist
CREATE FUNCTION IF NOT EXISTS is_encrypted(data VARCHAR(255)) 
RETURNS BOOLEAN
DETERMINISTIC
BEGIN
    RETURN LENGTH(data) = 64 AND data REGEXP '^[a-f0-9]{64}$';
END //

-- Drop existing triggers if they exist
DROP TRIGGER IF EXISTS before_user_insert //
DROP TRIGGER IF EXISTS before_user_update //

-- Create the insert trigger
CREATE TRIGGER before_user_insert 
BEFORE INSERT ON users
FOR EACH ROW
BEGIN
    IF NEW.encryption_enabled = 1 THEN
        SET NEW.name = encrypt_data(NEW.name);
        SET NEW.email = encrypt_data(NEW.email);
        SET NEW.role_name = encrypt_data(NEW.role_name);
        SET NEW.department = encrypt_data(NEW.department);
        SET NEW.position = encrypt_data(NEW.position);
    END IF;
END //

-- Create the update trigger
CREATE TRIGGER before_user_update
BEFORE UPDATE ON users
FOR EACH ROW
BEGIN
    IF NEW.encryption_enabled = 1 THEN
        IF NOT is_encrypted(NEW.name) THEN
            SET NEW.name = encrypt_data(NEW.name);
        END IF;
        IF NOT is_encrypted(NEW.email) THEN
            SET NEW.email = encrypt_data(NEW.email);
        END IF;
        IF NOT is_encrypted(NEW.role_name) THEN
            SET NEW.role_name = encrypt_data(NEW.role_name);
        END IF;
        IF NOT is_encrypted(NEW.department) THEN
            SET NEW.department = encrypt_data(NEW.department);
        END IF;
        IF NOT is_encrypted(NEW.position) THEN
            SET NEW.position = encrypt_data(NEW.position);
        END IF;
    END IF;
END //

-- Encrypt existing data
UPDATE users 
SET 
    name = encrypt_data(name),
    email = encrypt_data(email),
    role_name = encrypt_data(role_name),
    department = encrypt_data(department),
    position = encrypt_data(position)
WHERE encryption_enabled = 1;

DELIMITER ; 