DELIMITER //

DROP PROCEDURE IF EXISTS toggle_encryption //

CREATE PROCEDURE toggle_encryption(IN enable_encryption BOOLEAN)
BEGIN
    DECLARE EXIT HANDLER FOR SQLEXCEPTION
    BEGIN
        ROLLBACK;
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Error occurred during encryption toggle';
    END;

    START TRANSACTION;
    
    -- Update encryption_enabled for all users
    UPDATE users SET encryption_enabled = enable_encryption;
    
    -- If enabling encryption, encrypt all unencrypted data
    IF enable_encryption = 1 THEN
        UPDATE users 
        SET 
            name = CASE WHEN NOT is_encrypted(name) THEN encrypt_data(name) ELSE name END,
            email = CASE WHEN NOT is_encrypted(email) THEN encrypt_data(email) ELSE email END,
            role_name = CASE WHEN NOT is_encrypted(role_name) THEN encrypt_data(role_name) ELSE role_name END,
            department = CASE WHEN NOT is_encrypted(department) THEN encrypt_data(department) ELSE department END,
            position = CASE WHEN NOT is_encrypted(position) THEN encrypt_data(position) ELSE position END
        WHERE encryption_enabled = 1;
    END IF;

    COMMIT;
END //

DELIMITER ; 