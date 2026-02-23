ALTER TABLE usuarios
ADD COLUMN nombre_completo VARCHAR(100) AFTER usuario,
ADD COLUMN telefono VARCHAR(20) AFTER email,
ADD COLUMN direccion TEXT AFTER telefono,
ADD COLUMN fecha_nacimiento DATE AFTER direccion,
ADD COLUMN genero ENUM('M','F','O') AFTER fecha_nacimiento,
ADD COLUMN notas TEXT AFTER rol;
