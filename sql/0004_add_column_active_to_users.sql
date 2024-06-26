 -- Добавляем колонку active в users --
alter table `users1` 
    add column `active` tinyint(1) not null default 1 after `lastname`;