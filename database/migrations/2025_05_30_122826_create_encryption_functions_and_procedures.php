<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class CreateEncryptionFunctionsAndProcedures extends Migration
{
    public function up()
    {
        // Create encryption function
        DB::unprepared('
            CREATE FUNCTION IF NOT EXISTS encrypt_data(data VARCHAR(255)) 
            RETURNS VARCHAR(255)
            DETERMINISTIC
            BEGIN
                RETURN SHA2(data, 256);
            END;
        ');

        // Create check function
        DB::unprepared('
            CREATE FUNCTION IF NOT EXISTS is_encrypted(data VARCHAR(255)) 
            RETURNS BOOLEAN
            DETERMINISTIC
            BEGIN
                RETURN LENGTH(data) = 64 AND data REGEXP "^[a-f0-9]{64}$";
            END;
        ');

        // Create toggle procedure
        DB::unprepared('
            DROP PROCEDURE IF EXISTS toggle_encryption;
            
            CREATE PROCEDURE toggle_encryption(IN enable_encryption BOOLEAN)
            BEGIN
                DECLARE EXIT HANDLER FOR SQLEXCEPTION
                BEGIN
                    ROLLBACK;
                    SIGNAL SQLSTATE "45000" SET MESSAGE_TEXT = "Error occurred during encryption toggle";
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
            END;
        ');
    }

    public function down()
    {
        // Drop the procedures and functions
        DB::unprepared('DROP PROCEDURE IF EXISTS toggle_encryption;');
        DB::unprepared('DROP FUNCTION IF EXISTS encrypt_data;');
        DB::unprepared('DROP FUNCTION IF EXISTS is_encrypted;');
    }
}
