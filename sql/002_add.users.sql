                  -- Таблица пользователей --
create table if not exists `users1` (
    `id` int NOT NULL PRIMARY KEY AUTO_INCREMENT,
    `name` CHAR(50) NOT NULL,
   `lastname` CHAR(50) NOT NULL
 )
engine = innodb
auto_increment = 1
character set utf8
collate utf8_general_ci;

