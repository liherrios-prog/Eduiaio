DELIMITER $$

DROP TRIGGER IF EXISTS `usuarios_insert`$$
CREATE TRIGGER `usuarios_insert` AFTER INSERT ON `usuarios` FOR EACH ROW BEGIN
    INSERT INTO auditoria (tabla, accion, registro_id, detalles)
    VALUES ('usuarios', 'INSERTAR', NEW.id, CONCAT('Nuevo usuario registrado: ', NEW.usuario, ' (Nombre: ', IFNULL(NEW.nombre_completo, 'N/A'), ', Rol: ', NEW.rol, ')'));
END$$

DROP TRIGGER IF EXISTS `usuarios_update`$$
CREATE TRIGGER `usuarios_update` AFTER UPDATE ON `usuarios` FOR EACH ROW BEGIN
    DECLARE cambios TEXT DEFAULT '';
    
    IF OLD.rol != NEW.rol THEN
        SET cambios = CONCAT(cambios, 'Rol cambiado de ', OLD.rol, ' a ', NEW.rol, '. ');
    END IF;
    
    IF OLD.email != NEW.email THEN
        SET cambios = CONCAT(cambios, 'Email cambiado de ', OLD.email, ' a ', NEW.email, '. ');
    END IF;

    IF IFNULL(OLD.nombre_completo, '') != IFNULL(NEW.nombre_completo, '') THEN
        SET cambios = CONCAT(cambios, 'Nombre cambiado de "', IFNULL(OLD.nombre_completo, ''), '" a "', IFNULL(NEW.nombre_completo, ''), '". ');
    END IF;

    IF IFNULL(OLD.telefono, '') != IFNULL(NEW.telefono, '') THEN
        SET cambios = CONCAT(cambios, 'Teléfono cambiado. ');
    END IF;

    IF IFNULL(OLD.direccion, '') != IFNULL(NEW.direccion, '') THEN
        SET cambios = CONCAT(cambios, 'Dirección actualizada. ');
    END IF;

    IF IFNULL(OLD.notas, '') != IFNULL(NEW.notas, '') THEN
        SET cambios = CONCAT(cambios, 'Notas administrativas actualizadas. ');
    END IF;

    IF cambios != '' THEN
        INSERT INTO auditoria (tabla, accion, registro_id, detalles)
        VALUES ('usuarios', 'ACTUALIZAR', OLD.id, cambios);
    END IF;
END$$

DELIMITER ;
