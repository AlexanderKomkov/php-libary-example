-- Adminer 4.8.1 PostgreSQL 15.2 (Debian 15.2-1.pgdg110+1) dump

DROP TABLE IF EXISTS "authors";
DROP SEQUENCE IF EXISTS authors_id_seq;
CREATE SEQUENCE authors_id_seq INCREMENT 1 MINVALUE 1 MAXVALUE 2147483647 CACHE 1;

CREATE TABLE "public"."authors" (
    "id" integer DEFAULT nextval('authors_id_seq') NOT NULL,
    "first_name" character varying(45) NOT NULL,
    "last_name" character varying(45) NOT NULL,
    CONSTRAINT "authors_pkey" PRIMARY KEY ("id")
) WITH (oids = false);

INSERT INTO "authors" ("id", "first_name", "last_name") VALUES
(7,	'Алексей',	'Покровский'),
(8,	'Валерий',	'Гурвич'),
(9,	'Геннадий',	'Бебенков'),
(10,	'Дмитрий',	'Федотов'),
(11,	'Питер',	'Кэлдер'),
(12,	'Дарон',	'Аджемоглу'),
(13,	'Джеймс',	'Робинсон'),
(14,	'Кент',	'Бек'),
(15,	'Анна',	'Батлук'),
(16,	'Лаймен',	'Баум');

DROP TABLE IF EXISTS "authors_has_books";
CREATE TABLE "public"."authors_has_books" (
    "authors_id" integer NOT NULL,
    "books_id" integer NOT NULL
) WITH (oids = false);

INSERT INTO "authors_has_books" ("authors_id", "books_id") VALUES
(10,	23),
(9,	23),
(8,	23),
(7,	23),
(11,	24),
(13,	25),
(12,	25),
(14,	26),
(15,	27),
(16,	28);

DROP TABLE IF EXISTS "books";
DROP SEQUENCE IF EXISTS books_id_seq;
CREATE SEQUENCE books_id_seq INCREMENT 1 MINVALUE 1 MAXVALUE 2147483647 CACHE 1;

CREATE TABLE "public"."books" (
    "id" integer DEFAULT nextval('books_id_seq') NOT NULL,
    "title" character varying(255) NOT NULL,
    "count" integer NOT NULL,
    CONSTRAINT "books_pkey" PRIMARY KEY ("id")
) WITH (oids = false);

INSERT INTO "books" ("id", "title", "count") VALUES
(23,	'Проблемы лечебного голодания. Клинико-экспериментальные исследования',	3),
(24,	'Древний секрет источника молодости',	5),
(25,	'Узкий коридор',	7),
(26,	'Экстремальное программирование',	12),
(27,	'Студентка в подарок',	3),
(28,	'Волшебство страны Оз',	5);

DROP TABLE IF EXISTS "genres";
DROP SEQUENCE IF EXISTS genred_id_seq;
CREATE SEQUENCE genred_id_seq INCREMENT 1 MINVALUE 1 MAXVALUE 2147483647 CACHE 1;

CREATE TABLE "public"."genres" (
    "id" integer DEFAULT nextval('genred_id_seq') NOT NULL,
    "title" character varying(45) NOT NULL,
    CONSTRAINT "genred_pkey" PRIMARY KEY ("id")
) WITH (oids = false);

INSERT INTO "genres" ("id", "title") VALUES
(8,	'Альтернативная медицина'),
(9,	'Биология'),
(10,	'Здоровье'),
(11,	'Саморазвитие'),
(12,	'Самосовершенствование'),
(13,	'Политика'),
(14,	'Публицистика'),
(15,	'Экономика'),
(16,	'Компьютеры и Интернет'),
(17,	'Научная литература'),
(18,	'Фэнтези'),
(19,	'Сказки народов мира');

DROP TABLE IF EXISTS "genres_has_books";
CREATE TABLE "public"."genres_has_books" (
    "genres_id" integer NOT NULL,
    "books_id" integer NOT NULL
) WITH (oids = false);

INSERT INTO "genres_has_books" ("genres_id", "books_id") VALUES
(10,	23),
(9,	23),
(8,	23),
(12,	24),
(11,	24),
(15,	25),
(14,	25),
(13,	25),
(17,	26),
(16,	26),
(18,	27),
(19,	28);

DROP TABLE IF EXISTS "user_books";
DROP SEQUENCE IF EXISTS user_books_id_seq;
CREATE SEQUENCE user_books_id_seq INCREMENT 1 MINVALUE 1 MAXVALUE 2147483647 CACHE 1;

CREATE TABLE "public"."user_books" (
    "id" integer DEFAULT nextval('user_books_id_seq') NOT NULL,
    "users_id" integer NOT NULL,
    "books_id" integer NOT NULL,
    "date" date NOT NULL,
    CONSTRAINT "user_books_pkey" PRIMARY KEY ("id")
) WITH (oids = false);

INSERT INTO "user_books" ("id", "users_id", "books_id", "date") VALUES
(8,	52,	28,	'2023-05-10'),
(9,	50,	27,	'2023-06-17'),
(10,	49,	24,	'2023-08-21'),
(11,	48,	23,	'2023-09-12'),
(12,	49,	25,	'2023-05-10');

DROP TABLE IF EXISTS "users";
DROP SEQUENCE IF EXISTS users_id_seq;
CREATE SEQUENCE users_id_seq INCREMENT 1 MINVALUE 1 MAXVALUE 2147483647 CACHE 1;

CREATE TABLE "public"."users" (
    "id" integer DEFAULT nextval('users_id_seq') NOT NULL,
    "first_name" character varying(45),
    "last_name" character varying(45),
    "email" character varying(45) NOT NULL,
    "password" character varying(255) NOT NULL,
    CONSTRAINT "users_email" UNIQUE ("email"),
    CONSTRAINT "users_pkey" PRIMARY KEY ("id")
) WITH (oids = false);

INSERT INTO "users" ("id", "first_name", "last_name", "email", "password") VALUES
(48,	'Михаил',	'Голованов',	'miharulid@mail.ru',	'$2y$10$.D1WEnfSxNfj/zk6UfVQPOPH5WjjWafLNjwRSw7.EIiFMTEVx7s4u'),
(49,	'Егор',	'Осипов',	'osip@gmail.com',	'$2y$10$JbcBItbg56m1o8Vrkauade/L/nwWyCwjJ4V7wWaZBa3WbaCcw/wlG'),
(50,	'Вячеслав',	'Баженов',	'slava@mail.ru',	'$2y$10$jjcWv/tDneqkdCcuNHM01e44FWRMsmPwLT7lR7QLNJllIwjBqpdKa'),
(51,	'Александра',	'Воронцова',	'sasha@yandex.ru',	'$2y$10$J2slQulq7SksiREh41nBk.GRnUFG8xdHXGS9KLmxGFz0DXEbtfYIW'),
(52,	'Анастасия',	'Литвинова',	'nastya@mail.ru',	'$2y$10$1ZVOfKTDkvsOgypnsgmTp.UsmpwfH2gbNdjH5mGkoMhMvRqs9kQba');

ALTER TABLE ONLY "public"."authors_has_books" ADD CONSTRAINT "authodrs_has_books_authors_id_fkey" FOREIGN KEY (authors_id) REFERENCES authors(id) NOT DEFERRABLE;
ALTER TABLE ONLY "public"."authors_has_books" ADD CONSTRAINT "authodrs_has_books_books_id_fkey" FOREIGN KEY (books_id) REFERENCES books(id) NOT DEFERRABLE;

ALTER TABLE ONLY "public"."genres_has_books" ADD CONSTRAINT "genres_has_books_books_id_fkey" FOREIGN KEY (books_id) REFERENCES books(id) NOT DEFERRABLE;
ALTER TABLE ONLY "public"."genres_has_books" ADD CONSTRAINT "genres_has_books_genres_id_fkey" FOREIGN KEY (genres_id) REFERENCES genres(id) NOT DEFERRABLE;

ALTER TABLE ONLY "public"."user_books" ADD CONSTRAINT "user_books_books_id_fkey" FOREIGN KEY (books_id) REFERENCES books(id) NOT DEFERRABLE;
ALTER TABLE ONLY "public"."user_books" ADD CONSTRAINT "user_books_users_id_fkey" FOREIGN KEY (users_id) REFERENCES users(id) NOT DEFERRABLE;

-- 2023-04-16 09:40:38.41595+00