-- Triggers de Auditoría

DELIMITER //

-- 1. USUARIOS
-- Insertar
CREATE TRIGGER usuarios_insert 
AFTER INSERT ON usuarios
FOR EACH ROW 
BEGIN
    INSERT INTO auditoria (tabla, accion, registro_id, detalles)
    VALUES ('usuarios', 'INSERTAR', NEW.id, CONCAT('Nuevo usuario registrado: ', NEW.usuario, ' (Rol: ', NEW.rol, ')'));
END//

-- Actualizar
CREATE TRIGGER usuarios_update 
AFTER UPDATE ON usuarios
FOR EACH ROW 
BEGIN
    DECLARE cambios TEXT DEFAULT '';
    
    IF OLD.rol != NEW.rol THEN
        SET cambios = CONCAT(cambios, 'Rol cambiado de ', OLD.rol, ' a ', NEW.rol, '. ');
    END IF;
    
    IF OLD.email != NEW.email THEN
        SET cambios = CONCAT(cambios, 'Email cambiado de ', OLD.email, ' a ', NEW.email, '. ');
    END IF;

    IF cambios != '' THEN
        INSERT INTO auditoria (tabla, accion, registro_id, detalles)
        VALUES ('usuarios', 'ACTUALIZAR', OLD.id, cambios);
    END IF;
END//

-- Eliminar
CREATE TRIGGER usuarios_delete 
AFTER DELETE ON usuarios
FOR EACH ROW 
BEGIN
    INSERT INTO auditoria (tabla, accion, registro_id, detalles)
    VALUES ('usuarios', 'ELIMINAR', OLD.id, CONCAT('Usuario eliminado: ', OLD.usuario));
END//


-- 2. CATEGORIAS
-- Insertar
CREATE TRIGGER categorias_insert 
AFTER INSERT ON categorias
FOR EACH ROW 
BEGIN
    INSERT INTO auditoria (tabla, accion, registro_id, detalles)
    VALUES ('categorias', 'INSERTAR', NEW.id, CONCAT('Nueva categoría creada: ', NEW.nombre));
END//

-- Actualizar
CREATE TRIGGER categorias_update 
AFTER UPDATE ON categorias
FOR EACH ROW 
BEGIN
    IF OLD.nombre != NEW.nombre THEN
        INSERT INTO auditoria (tabla, accion, registro_id, detalles)
        VALUES ('categorias', 'ACTUALIZAR', OLD.id, CONCAT('Nombre de categoría cambiado de ', OLD.nombre, ' a ', NEW.nombre));
    END IF;
END//

-- Eliminar
CREATE TRIGGER categorias_delete 
AFTER DELETE ON categorias
FOR EACH ROW 
BEGIN
    INSERT INTO auditoria (tabla, accion, registro_id, detalles)
    VALUES ('categorias', 'ELIMINAR', OLD.id, CONCAT('Categoría eliminada: ', OLD.nombre));
END//


-- 3. CURSOS (Complementa al trigger existente de precio)
-- Insertar
CREATE TRIGGER cursos_insert 
AFTER INSERT ON cursos
FOR EACH ROW 
BEGIN
    INSERT INTO auditoria (tabla, accion, registro_id, detalles)
    VALUES ('cursos', 'INSERTAR', NEW.id, CONCAT('Nuevo curso creado: ', NEW.titulo));
END//

-- Eliminar
CREATE TRIGGER cursos_delete 
AFTER DELETE ON cursos
FOR EACH ROW 
BEGIN
    INSERT INTO auditoria (tabla, accion, registro_id, detalles)
    VALUES ('cursos', 'ELIMINAR', OLD.id, CONCAT('Curso eliminado: ', OLD.titulo));
END//

DELIMITER ;
