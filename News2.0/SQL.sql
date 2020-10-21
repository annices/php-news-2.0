CREATE TABLE IF NOT EXISTS a_news (
  id int(11) AUTO_INCREMENT,
  subject varchar(256) NOT NULL,
  entry varchar(1000),
  created datetime,
PRIMARY KEY (id)
);

CREATE TABLE IF NOT EXISTS a_admin (
  id int(11) AUTO_INCREMENT,
  username varchar(256),
  password varchar(2048),
PRIMARY KEY (id),
UNIQUE KEY(username)
);