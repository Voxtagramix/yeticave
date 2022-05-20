/*Добавление*/
INSERT INTO `categories`(`name`)
VALUES ('Доски и лыжи'), ('Крепления'),('Ботинки'),('Одежда'),('Инструменты'),('Разное');

INSERT INTO `users`(`user_name`, `avatar`,`email`,`password`,`contacts`)
VALUES ('Павел', 'img/avatar.jpg', 'pavel@yandex.ru', 'zxc123', '89857389691'),
	('Александр','img/avatar','sasha@mail.ru','sasha23','89453814563'),
	('Никита','img/avatar','nikita@mail.ru','nikita18','89891234896'),
	('Ольга','img/avatar','olga@rambler.ru','olga21','89473654267');

INSERT INTO `lots`(`lot_name`,`description`,`id_user`,`id_category`,`id_winner`,`img`,`start_price`,`step_price`,`data_over`)
VALUES ('2014 Rossignol District Snowboard', 'Just nice Snowboard', 1,1,NUll,'img/lot-1.jpg',10998,500,'2022-05-20'),
       ('DC Ply Mens 2016/2017 Snowboardd', 'Just nice Snowboard', 2,1,3,'img/lot-2.jpg',159999,1000,'2022-05-22'),
       ('Крепления Union Contact Pro 2015 года размер L/XL', 'Крепления размера XL/L', 3,2,1,'img/lot-3.jpg',8000,400,'2022-05-20'),
       ('Ботинки для сноуборда DC Mutiny Charocal', 'Ботинки', 4,3,2,'img/lot-4.jpg',10999,500,'2022-05-23'),
       ('Куртка для сноуборда DC Mutiny Charocal', 'Куртка', 1,4,NUll,'img/lot-5.jpg',7500,400,'2022-05-28'),
       ('Маска Oakley Canopy', 'Маска', 2,6,1,'img/lot-6.jpg',7500,1000,'2022-05-29');
INSERT INTO `bids`(`id_user`, `id_lot`, `price`)
VALUES('2','1',500),
      ('2','3',600),
      ('3','1',1000),
      ('4','5',1000);

/*Запросы 2.*/
SELECT * from `categories`;/*Выбрать все категории*/
SET GLOBAL sql_mode=(SELECT REPLACE(@@sql_mode,'ONLY_FULL_GROUP_BY',''));/*Для второго задания*/
Select a.name as name,
       start_price,
       a.img,
       (COALESCE(sum(b.price),0)+a.start_price) Cost,
       count(b.price)Bids,
       c.name as categories,
       id_winner
from lots as a
       left join bids b
                 on a.id_lotting = b.id_lot
       inner join categories c on a.id_category = c.id_cat
group by a.name, start_price, img,data_start,id_winner
having ISNULL(id_winner)
order by data_start desc;
/*получить самые новые, открытые лоты. Каждый лот должен включать
название, стартовую цену, ссылку на изображение, цену последней ставки,
количество ставок, название категории;*/
select * from lots inner join categories c on lots.id_category=c.id where lots.id_lotting=1;/*показать лот по его id. Получите также название категории, к которой
принадлежит лот*/
Update `lots` SET `name`='Изменен' WHERE `id`=1;/*Обновить название*/
select * from bids inner join lots on bids.id_lot=lots.id where lots.id_lotting=1;/*получить список самых свежих ставок для лота по его идентификатору;*/
