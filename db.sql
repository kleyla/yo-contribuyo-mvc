
CREATE DATABASE yo_contribuyo
DEFAULT CHARACTER  SET utf8;
USE yo_contribuyo;
CREATE TABLE usuarios (
  id_usuario INT NOT NULL UNIQUE AUTO_INCREMENT,
  nick VARCHAR(50) NOT NULL UNIQUE,
  email VARCHAR(255) NOT NULL UNIQUE,
  pass VARCHAR(255) NOT NULL,
  rol VARCHAR(20) NOT NULL,
  estado TINYINT NOT NULL DEFAULT 1,
  fecha DATETIME NOT NULL DEFAULT now(),
  PRIMARY KEY (id_usuario)
);

CREATE TABLE proyectos (
  id_proyecto INT NOT NULL UNIQUE AUTO_INCREMENT,
  usuario_id INT NOT NULL,
  nombre VARCHAR(255) NOT NULL,
  descripcion TEXT CHARACTER SET utf8 NOT NULL,
  repositorio VARCHAR(255) NOT NULL UNIQUE,
  tags TEXT CHARACTER SET utf8,
  estado TINYINT NOT NULL DEFAULT 1,
  fecha DATETIME NOT NULL DEFAULT now(),
  PRIMARY KEY (id_proyecto),
  FOREIGN KEY (usuario_id) REFERENCES usuarios(id_usuario) ON UPDATE CASCADE ON DELETE RESTRICT
);
CREATE TABLE lenguajes (
  id_lenguaje INT NOT NULL UNIQUE AUTO_INCREMENT,
  nombre VARCHAR(255) NOT NULL UNIQUE,
  link TEXT CHARACTER SET utf8 NOT NULL,
  estado TINYINT NOT NULL DEFAULT 1,
  fecha DATETIME NOT NULL DEFAULT now(),
  PRIMARY KEY (id_lenguaje)
);
CREATE TABLE proyecto_lenguaje (
  proyecto_id INT NOT NULL,
  lenguaje_id INT NOT NULL,
  
  FOREIGN KEY (proyecto_id) REFERENCES proyectos(id_proyecto) ON UPDATE CASCADE ON DELETE RESTRICT,
  FOREIGN KEY (lenguaje_id) REFERENCES lenguajes(id_lenguaje) ON UPDATE CASCADE ON DELETE RESTRICT
  
);

CREATE TABLE articulos (
  id_articulo INT NOT NULL UNIQUE AUTO_INCREMENT,
  usuario_id INT NOT NULL,
  titulo VARCHAR(255) NOT NULL UNIQUE,
  contenido TEXT CHARACTER SET utf8 NOT NULL,
  estado TINYINT NOT NULL DEFAULT 1,
  fecha DATETIME NOT NULL DEFAULT now(),
  PRIMARY KEY (id_articulo),
  FOREIGN KEY (usuario_id) REFERENCES usuarios(id_usuario) ON UPDATE CASCADE ON DELETE RESTRICT
);

CREATE TABLE detalle_denuncia (
  articulo_id INT NOT NULL,
  usuario_id INT NOT NULL,
  
  FOREIGN KEY (articulo_id) REFERENCES articulos(id_articulo) ON UPDATE CASCADE ON DELETE RESTRICT,
  FOREIGN KEY (usuario_id) REFERENCES usuarios(id_usuario) ON UPDATE CASCADE ON DELETE RESTRICT
  
);

CREATE TABLE acciones (
  id_accion INT NOT NULL UNIQUE AUTO_INCREMENT,
  usuario_id INT NOT NULL,
  proyecto_id INT NOT NULL,
  estado TINYINT NOT NULL DEFAULT 1,
  fecha DATETIME NOT NULL DEFAULT now(),
  PRIMARY KEY (id_accion),
  FOREIGN KEY (usuario_id) REFERENCES usuarios(id_usuario) ON UPDATE CASCADE ON DELETE RESTRICT,
  FOREIGN KEY (proyecto_id) REFERENCES proyectos(id_proyecto) ON UPDATE CASCADE ON DELETE RESTRICT
);
CREATE TABLE comentarios (
  -- id_comentario INT NOT NULL UNIQUE AUTO_INCREMENT,
  contenido TEXT CHARACTER SET utf8 NOT NULL,
  accion_id INT NOT NULL,
  PRIMARY KEY (accion_id),
  FOREIGN KEY (accion_id) REFERENCES acciones(id_accion) ON UPDATE CASCADE ON DELETE RESTRICT
);
CREATE TABLE calificaciones (
  -- id_calificacion INT NOT NULL UNIQUE AUTO_INCREMENT,
  accion_id INT NOT NULL,
  estrellas FLOAT NOT NULL,
  PRIMARY KEY (accion_id),
  FOREIGN KEY (accion_id) REFERENCES acciones(id_accion) ON UPDATE CASCADE ON DELETE RESTRICT
);
-- DATA

-- USUARIOS
INSERT INTO usuarios(nick, email, pass, rol) VALUES ('leyla','leyla@live.com','96cae35ce8a9b0244178bf28e4966c2ce1b8385723a96a6b838858cdd6ca0a1e', 'Administrador');
INSERT INTO usuarios(nick, email, pass, rol) VALUES ('karen','karen@live.com','96cae35ce8a9b0244178bf28e4966c2ce1b8385723a96a6b838858cdd6ca0a1e', 'Administrador');
INSERT INTO usuarios(nick, email, pass, rol) VALUES ('alejandra','alejandra@live.com','96cae35ce8a9b0244178bf28e4966c2ce1b8385723a96a6b838858cdd6ca0a1e', 'Administrador');
INSERT INTO usuarios(nick, email, pass, rol) VALUES ('yolanda','landa@live.com','96cae35ce8a9b0244178bf28e4966c2ce1b8385723a96a6b838858cdd6ca0a1e', 'Contribuidor');

-- LENGUAJES
INSERT INTO lenguajes(nombre, link) VALUES ("Javascript",'https://www.javascript.com/');
INSERT INTO lenguajes(nombre, link) VALUES ("PHP",'https://www.php.net/');
INSERT INTO lenguajes(nombre, link) VALUES ("Go",'https://golang.org/');
INSERT INTO lenguajes(nombre, link) VALUES ("Assembly",'https://en.wikipedia.org/wiki/Assembly');
INSERT INTO lenguajes(nombre, link) VALUES ("Scala",'https://scala-lang.org/');
INSERT INTO lenguajes(nombre, link) VALUES ("C#",'https://ru.wikipedia.org/wiki/C_Sharp');
INSERT INTO lenguajes(nombre, link) VALUES ("Swift",'https://www.swift.com/');
INSERT INTO lenguajes(nombre, link) VALUES ("Perl",'https://www.perl.org/');
INSERT INTO lenguajes(nombre, link) VALUES ("Dart",'https://dart.dev/');
INSERT INTO lenguajes(nombre, link) VALUES ("Java",'https://www.java.com/es/');
INSERT INTO lenguajes(nombre, link) VALUES ("Vue",'https://vuejs.org/');
INSERT INTO lenguajes(nombre, link) VALUES ("Typescript",'https://www.typescriptlang.org/');
INSERT INTO lenguajes(nombre, link) VALUES ("CSS",'https://en.wikipedia.org/wiki/CSS');
INSERT INTO lenguajes(nombre, link) VALUES ("Ruby",'https://www.ruby-lang.org/es/');
INSERT INTO lenguajes(nombre, link) VALUES ("Kotlin",'https://kotlinlang.org/');
INSERT INTO lenguajes(nombre, link) VALUES ("Sass",'https://sass-lang.com/');
INSERT INTO lenguajes(nombre, link) VALUES ("Rust",'https://www.rust-lang.org/');
INSERT INTO lenguajes(nombre, link) VALUES ("Less",'http://lesscss.org/');
INSERT INTO lenguajes(nombre, link) VALUES ("C++",'https://www.cplusplus.com/doc/tutorial/');
INSERT INTO lenguajes(nombre, link) VALUES ("C",'https://en.wikipedia.org/wiki/C_(programming_language)');
INSERT INTO lenguajes(nombre, link) VALUES ("TeX",'https://en.wikipedia.org/wiki/TeX');
INSERT INTO lenguajes(nombre, link) VALUES ("Shell",'https://en.wikipedia.org/wiki/Shell_(computing)');
INSERT INTO lenguajes(nombre, link) VALUES ("Julia",'https://julialang.org/');
INSERT INTO lenguajes(nombre, link) VALUES ("HTML",'https://en.wikipedia.org/wiki/HTML');
INSERT INTO lenguajes(nombre, link) VALUES ("Python",'https://www.python.org/');
INSERT INTO lenguajes(nombre, link) VALUES ("R",'https://www.r-project.org/');

-- PROYECTOS
INSERT INTO proyectos(nombre, descripcion, repositorio, tags, usuario_id) VALUES ("Awesome for beginners", 'Impresionantes primeras oportunidades de Pull request. Una lista de proyectos increíbles para principiantes. Si es un mantenedor de proyectos de código abierto, agregue la etiqueta solo para principiantes a su proyecto y anótelo aquí para que la gente pueda encontrarlo. Si está buscando contribuir, explore esta lista, observe los problemas abiertos etiquetados solo para principiantes.', 'https://github.com/mungell/awesome-for-beginners','first-time-issue', 1);
INSERT INTO proyectos(nombre, descripcion, repositorio, tags, usuario_id) VALUES ("Awesome for non-programmers","Here comes a list of Open Source projects where you can contribute without any programming knowledge.","https://github.com/szabgab/awesome-for-non-programmers",'first-time-issue', 1);
-- INSERT INTO proyectos(nombre, descripcion, repositorio, tags, usuario_id) VALUES ("","","",,'first-time-issue', 1);

INSERT INTO proyecto_lenguaje(proyecto_id, lenguaje_id) VALUES ('1','1');
INSERT INTO proyecto_lenguaje(proyecto_id, lenguaje_id) VALUES ('1','2');
INSERT INTO proyecto_lenguaje(proyecto_id, lenguaje_id) VALUES ('1','3');
INSERT INTO proyecto_lenguaje(proyecto_id, lenguaje_id) VALUES ('1','4');
INSERT INTO proyecto_lenguaje(proyecto_id, lenguaje_id) VALUES ('1','5');
INSERT INTO proyecto_lenguaje(proyecto_id, lenguaje_id) VALUES ('1','6');
INSERT INTO proyecto_lenguaje(proyecto_id, lenguaje_id) VALUES ('1','7');
INSERT INTO proyecto_lenguaje(proyecto_id, lenguaje_id) VALUES ('1','8');
INSERT INTO proyecto_lenguaje(proyecto_id, lenguaje_id) VALUES ('1','9');
INSERT INTO proyecto_lenguaje(proyecto_id, lenguaje_id) VALUES ('1','10');
INSERT INTO proyecto_lenguaje(proyecto_id, lenguaje_id) VALUES ('1','11');
INSERT INTO proyecto_lenguaje(proyecto_id, lenguaje_id) VALUES ('1','12');
INSERT INTO proyecto_lenguaje(proyecto_id, lenguaje_id) VALUES ('1','13');
INSERT INTO proyecto_lenguaje(proyecto_id, lenguaje_id) VALUES ('1','14');
INSERT INTO proyecto_lenguaje(proyecto_id, lenguaje_id) VALUES ('1','15');
INSERT INTO proyecto_lenguaje(proyecto_id, lenguaje_id) VALUES ('1','16');
INSERT INTO proyecto_lenguaje(proyecto_id, lenguaje_id) VALUES ('1','17');
INSERT INTO proyecto_lenguaje(proyecto_id, lenguaje_id) VALUES ('1','18');
INSERT INTO proyecto_lenguaje(proyecto_id, lenguaje_id) VALUES ('1','19');
INSERT INTO proyecto_lenguaje(proyecto_id, lenguaje_id) VALUES ('1','20');
INSERT INTO proyecto_lenguaje(proyecto_id, lenguaje_id) VALUES ('2','10');
-- INSERT INTO proyecto_lenguaje(proyecto_id, lenguaje_id) VALUES ('3','');

-- ARTICULOS
INSERT INTO articulos(titulo, contenido, usuario_id) VALUES ("Octocat", 'Articulo de Octocats', 1);

INSERT INTO acciones(usuario_id, proyecto_id) VALUES(1,1);
INSERT INTO acciones(usuario_id, proyecto_id) VALUES(2,1);

INSERT INTO comentarios(accion_id, contenido) VALUES(1,'Lorem ipsum dolor, sit amet consectetur adipisicing elit. Sapiente harum laudantium soluta sunt, modi quas, saepe quis maiores inventore cum, nostrum veniam accusantium. Quos dolorem consequatur similique explicabo enim? Esse.');
INSERT INTO comentarios(accion_id, contenido) VALUES(2,'Holier');