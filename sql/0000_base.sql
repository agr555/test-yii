-- ���� ������������ ���� --
 
-- ������� ������� --
create table `goods` (
    `id` int(10) unsigned not null auto_increment,
    `name` varchar(255) not null,
    `price` int(11) not null,
    primary key (id)
)
engine = innodb
auto_increment = 1
character set utf8
collate utf8_general_ci;
 
-- ������ �� ������� ������� --
insert into `goods` (`name`, `price`) values
    ('�������', 30000),
    ('�������', 20000);
 
-- /���� ������������ ���� --
 
 
-- ������� versions --
create table if not exists `versions` (
    `id` int(10) unsigned not null auto_increment,
    `name` varchar(255) not null,
    `created` timestamp default current_timestamp,
    primary key (id)
)
engine = innodb
auto_increment = 1
character set utf8
collate utf8_general_ci;