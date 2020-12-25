
CREATE DATABASE yo_contribuyo
DEFAULT CHARACTER  SET utf8;
USE yo_contribuyo;
CREATE TABLE usuarios (
  id int NOT NULL UNIQUE AUTO_INCREMENT,
  nick VARCHAR(50) NOT NULL UNIQUE,
  email VARCHAR(255) NOT NULL UNIQUE,
  pass VARCHAR(255) NOT NULL,
  rol VARCHAR(20) NOT NULL,
  estado TINYINT NOT NULL,
  fecha DATETIME NOT NULL,
  PRIMARY KEY (id)
);


CREATE TABLE proyectos (
  id int NOT NULL UNIQUE AUTO_INCREMENT,
  usuario_id INT NOT NULL,
  nombre VARCHAR(255) NOT NULL UNIQUE,
  descripcion TEXT CHARACTER SET utf8 NOT NULL,
  link VARCHAR(255) NOT NULL,
  estado TINYINT NOT NULL,
  PRIMARY KEY (id),
  FOREIGN KEY (usuario_id) REFERENCES usuarios(id) ON UPDATE CASCADE ON DELETE RESTRICT
);
CREATE TABLE lenguajes (
  id int NOT NULL UNIQUE AUTO_INCREMENT,
  nombre VARCHAR(255) NOT NULL,
  link TEXT CHARACTER SET utf8 NOT NULL,
  estado TINYINT NOT NULL,
  fecha DATETIME NOT NULL,
  PRIMARY KEY (id)
);
CREATE TABLE tags (
  id int NOT NULL UNIQUE AUTO_INCREMENT,
  nombre VARCHAR(255) NOT NULL,
  estado TINYINT NOT NULL,
  fecha DATETIME NOT NULL,
  PRIMARY KEY (id)
);
CREATE TABLE proyecto_lenguaje (
  proyecto_id INT NOT NULL,
  lenguaje_id INT NOT NULL,
  
  FOREIGN KEY (proyecto_id) REFERENCES proyectos(id) ON UPDATE CASCADE ON DELETE RESTRICT,
  FOREIGN KEY (lenguaje_id) REFERENCES lenguajes(id) ON UPDATE CASCADE ON DELETE RESTRICT
  
);

CREATE TABLE articulos (
  id int NOT NULL UNIQUE AUTO_INCREMENT,
  usuario_id INT NOT NULL,
  titulo VARCHAR(255) NOT NULL UNIQUE,
  contenido TEXT CHARACTER SET utf8 NOT NULL,
  estado TINYINT NOT NULL,
  PRIMARY KEY (id),
  FOREIGN KEY (usuario_id) REFERENCES usuarios(id) ON UPDATE CASCADE ON DELETE RESTRICT
);

CREATE TABLE detalle_denuncia (
  articulo_id INT NOT NULL,
  usuario_id INT NOT NULL,
  
  FOREIGN KEY (articulo_id) REFERENCES articulos(id) ON UPDATE CASCADE ON DELETE RESTRICT,
  FOREIGN KEY (usuario_id) REFERENCES usuarios(id) ON UPDATE CASCADE ON DELETE RESTRICT
  
);

CREATE TABLE accion (
  usuario_id INT NOT NULL,
  proyecto_id INT NOT NULL,
  
  FOREIGN KEY (usuario_id) REFERENCES usuarios(id) ON UPDATE CASCADE ON DELETE RESTRICT,
  FOREIGN KEY (proyecto_id) REFERENCES proyectos(id) ON UPDATE CASCADE ON DELETE RESTRICT
  
);