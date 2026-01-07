DROP PROCEDURE IF EXISTS sp_reservar;
DELIMITER $$
CREATE PROCEDURE sp_reservar(
    IN p_dni VARCHAR(12),
    IN p_nombre VARCHAR(25),
    IN p_numero INT
)
BEGIN
    DECLARE cnt INT;
    SELECT COUNT(*) INTO cnt FROM pasajeros WHERE dni = p_dni;
    IF cnt > 0 THEN
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'DNI ya existe';
    END IF;

    START TRANSACTION;
        INSERT INTO pasajeros (dni, nombre, sexo, numero_plaza) VALUES (p_dni, p_nombre, '-', p_numero);
        UPDATE plazas SET reservada = 1 WHERE numero = p_numero;
    COMMIT;
END$$
DELIMITER ;