
CREATE DATABASE yo_contribuyo
DEFAULT CHARACTER  SET utf8;
USE yo_contribuyo;
CREATE TABLE usuarios (
  id_usuario int NOT NULL UNIQUE AUTO_INCREMENT,
  nick VARCHAR(50) NOT NULL UNIQUE,
  email VARCHAR(255) NOT NULL UNIQUE,
  pass VARCHAR(255) NOT NULL,
  rol VARCHAR(20) NOT NULL,
  estado TINYINT NOT NULL,
  fecha DATETIME NOT NULL,
  PRIMARY KEY (id_usuario)
);


CREATE TABLE proyectos (
  id_proyecto int NOT NULL UNIQUE AUTO_INCREMENT,
  usuario_id INT NOT NULL,
  nombre VARCHAR(255) NOT NULL,
  descripcion TEXT CHARACTER SET utf8 NOT NULL,
  repositorio VARCHAR(255) NOT NULL,
  estado TINYINT NOT NULL,
  fecha DATETIME NOT NULL,
  PRIMARY KEY (id_proyecto),
  FOREIGN KEY (usuario_id) REFERENCES usuarios(id_usuario) ON UPDATE CASCADE ON DELETE RESTRICT
);
CREATE TABLE lenguajes (
  id_lenguaje int NOT NULL UNIQUE AUTO_INCREMENT,
  nombre VARCHAR(255) NOT NULL UNIQUE,
  link TEXT CHARACTER SET utf8 NOT NULL,
  estado TINYINT NOT NULL,
  fecha DATETIME NOT NULL,
  PRIMARY KEY (id_lenguaje)
);
CREATE TABLE tags (
  id_tag int NOT NULL UNIQUE AUTO_INCREMENT,
  nombre VARCHAR(255) NOT NULL,
  estado TINYINT NOT NULL,
  fecha DATETIME NOT NULL,
  PRIMARY KEY (id_tag)
);
CREATE TABLE proyecto_lenguaje (
  proyecto_id INT NOT NULL,
  lenguaje_id INT NOT NULL,
  
  FOREIGN KEY (proyecto_id) REFERENCES proyectos(id_proyecto) ON UPDATE CASCADE ON DELETE RESTRICT,
  FOREIGN KEY (lenguaje_id) REFERENCES lenguajes(id_lenguaje) ON UPDATE CASCADE ON DELETE RESTRICT
  
);

CREATE TABLE articulos (
  id_articulo int NOT NULL UNIQUE AUTO_INCREMENT,
  usuario_id INT NOT NULL,
  titulo VARCHAR(255) NOT NULL UNIQUE,
  contenido TEXT CHARACTER SET utf8 NOT NULL,
  estado TINYINT NOT NULL,
  PRIMARY KEY (id_articulo),
  FOREIGN KEY (usuario_id) REFERENCES usuarios(id_usuario) ON UPDATE CASCADE ON DELETE RESTRICT
);

CREATE TABLE detalle_denuncia (
  articulo_id INT NOT NULL,
  usuario_id INT NOT NULL,
  
  FOREIGN KEY (articulo_id) REFERENCES articulos(id_articulo) ON UPDATE CASCADE ON DELETE RESTRICT,
  FOREIGN KEY (usuario_id) REFERENCES usuarios(id_usuario) ON UPDATE CASCADE ON DELETE RESTRICT
  
);

CREATE TABLE accion (
  usuario_id INT NOT NULL,
  proyecto_id INT NOT NULL,
  
  FOREIGN KEY (usuario_id) REFERENCES usuarios(id_usuario) ON UPDATE CASCADE ON DELETE RESTRICT,
  FOREIGN KEY (proyecto_id) REFERENCES proyectos(id_proyecto) ON UPDATE CASCADE ON DELETE RESTRICT
  
);

-- DATA

-- USUARIOS
INSERT INTO usuarios(nick, email, pass, estado, rol, fecha) VALUES ('leyla','leyla@live.com','123123',1,'Administrador', now());
INSERT INTO usuarios(nick, email, pass, estado, rol, fecha) VALUES ('karen','karen@live.com','123123',1,'Administrador', now());
INSERT INTO usuarios(nick, email, pass, estado, rol, fecha) VALUES ('alejandra','alejandra@live.com','123123',1,'Administrador', now());
INSERT INTO usuarios(nick, email, pass, estado, rol, fecha) VALUES ('yolanda','yolanda@live.com','123123',1,'Contribuidor', now());

-- LENGUAJES
INSERT INTO lenguajes(nombre, link, estado, fecha) VALUES ("Javascript",'https://www.javascript.com/',1, now());
INSERT INTO lenguajes(nombre, link, estado, fecha) VALUES ("PHP",'https://www.php.net/',1, now());
INSERT INTO lenguajes(nombre, link, estado, fecha) VALUES ("Go",'https://golang.org/',1, now());

-- PROYECTOS
INSERT INTO proyectos(nombre, descripcion, repositorio, estado, fecha, usuario_id) VALUES ("Octocat", 'Proyecto de Octocats', 'https://golang.org/',1, now(), 1);
