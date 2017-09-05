
/*
  Tabla categorio, se manejaran todas las categorias disponibles.
 */
CREATE TABLE Categories(
  id int AUTO_INCREMENT not null,
  Category_Name varchar(20) not null,
  CONSTRAINT PK_CategoryId PRIMARY KEY (id)
);

/*
  Tabla Preguntas, se manejan las preguntas y sus categorias.
 */
Create table Questions(
  id int AUTO_INCREMENT not null,
  Question varchar(60) not null,
  Difficulty varchaR(30) not null,
  idCategory int not null,
  CONSTRAINT PK_idQuestions PRIMARY KEY (id),
  CONSTRAINT FK_idCCategories FOREIGN KEY (idCategory) REFERENCES Categories(id)
);

/*
  Tabla Respuesta Correcta, se guardarán las respuestas de cada pregunta y su valor t o f en caso de ser correcta o no
 */
create table Answers(
  id int AUTO_INCREMENT not null,
  answer varchar(60) not null,
  correct bool not null,
  CONSTRAINT PK_idCorrect_Answer PRIMARY KEY (id)
);

/*
  Tablas Mucho a Mucho de Respuestas y Preguntas DUDOSO
 */

CREATE TABLE QuestionsAnswers(
  idQuestion int not null,
  idAnswer int not null,
  CONSTRAINT FK_idQuestion FOREIGN KEY (idQuestion) REFERENCES Questions(id),
  CONSTRAINT FK_idAnswer FOREIGN KEY (idAnswer) REFERENCES Answers(id)
);

/*
  Usuarios registrados en el sistema.
 */

CREATE TABLE Users(
  id int AUTO_INCREMENT not null,
  email varchar(30) UNIQUE not null,
  name varchar(30) not null,
  surname varchar(30) null,
  age date not null,
  user varchar(20) not null,
  password varchar(70) not null,
  CONSTRAINT PK_idUsers PRIMARY KEY (id)
);

/*
  Tabla de Rols
 */
CREATE TABLE Rolls(
  id int AUTO_INCREMENT not null,
  Name varchar(20) not null,
  Description_Roll varchar(30) null,
  CONSTRAINT PK_idRoll PRIMARY KEY (id)
);

/*
  Table de permisos, cada rol tendrá un permiso.
 */
CREATE TABLE Permissions(
  id int AUTO_INCREMENT not null,
  Type_Permission varchar(10) not null,
  Description_Permision varchar(30) null,
  CONSTRAINT PK_idPermissions PRIMARY KEY (id)
);

/*
  Tabla permisos y rols.
 */
CREATE TABLE RollsPermissions(
  idRoll int not null,
  idPermission int not null,
  CONSTRAINT FK_idRoll FOREIGN KEY (idRoll) REFERENCES Rolls(id),
  CONSTRAINT FK_idPermission FOREIGN KEY (idPermission) REFERENCES Permissions(id)
);

/*
  Tabla para registrar las jugadas, aqui se registraran el numero de jugadores con la id y los datos
  idUserCreate = Usuario que ha creado la partida
 */
CREATE TABLE Games(
  id int AUTO_INCREMENT not null,
  date Date null,
  idCategoria int not null,
  idUserCreator int not null,
  CONSTRAINT PK_idGames PRIMARY KEY (id),
  CONSTRAINT FK_idCategoria FOREIGN KEY (idCategoria) REFERENCES Categories(id),
  CONSTRAINT FK_idUserCreator FOREIGN KEY (idUserCreator) REFERENCES Users(id)
);

/*
  Tabla intermedia entre Games y Users, se monstrara cuantos usuarios han participado en dicha partida
 */
CREATE TABLE GamesUsers(
  idUser int not null,
  idGame int not null,
  Preparado DATE null,
  CONSTRAINT FK_idUser FOREIGN KEY (idUser) REFERENCES Users(id),
  CONSTRAINT FK_idGame FOREIGN KEY (idGame) REFERENCES Games(id)
);


SELECT a.id AS 'idAnswer' ,a.answer, a.correct FROM Answers AS a, Categories AS c,
  QuestionsAnswers AS qa, Questions q WHERE q.idCategory = c.id AND q.id = qa.idQuestion AND qa.idAnswer = a.id AND q.Difficulty = 'Media';
SELECT * FROM Questions;

INSERT INTO Questions(Difficulty, Question, idCategory) VALUE ('Media', '¿Es lo mismo un objeto que una clase?', 1);
INSERT INTO Answers(answer, correct) VALUEs ('Si', 1), ('No', 0);
INSERT INTO QuestionsAnswers(idQuestion, idAnswer) VALUES (1, 1), (1, 2);

SELECT * FROM QuestionsAnswers;