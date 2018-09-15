-- phpMyAdmin SQL Dump
-- version 4.8.0
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1
-- Время создания: Сен 15 2018 г., 16:47
-- Версия сервера: 10.1.31-MariaDB
-- Версия PHP: 7.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `auto`
--

-- --------------------------------------------------------

--
-- Структура таблицы `brands`
--

CREATE TABLE `brands` (
  `id` int(11) NOT NULL,
  `name` varchar(24) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Auto brands';

--
-- Дамп данных таблицы `brands`
--

INSERT INTO `brands` (`id`, `name`) VALUES
(1, 'BMW'),
(2, 'Audi'),
(3, 'Mercedes'),
(4, 'Renault'),
(5, 'Peugeot'),
(6, 'Citroen'),
(7, 'VW'),
(8, 'Toyota'),
(9, 'Nissan'),
(10, 'Mitshbishi'),
(11, 'GM'),
(12, 'Rover'),
(13, 'Fiat'),
(14, 'SEAT'),
(15, 'Lada'),
(16, 'Газ');

-- --------------------------------------------------------

--
-- Структура таблицы `cars`
--

CREATE TABLE `cars` (
  `id` int(11) NOT NULL,
  `vin` varchar(17) NOT NULL,
  `nick` varchar(8) NOT NULL,
  `plate` varchar(9) NOT NULL,
  `region` int(3) NOT NULL,
  `model_id` int(11) NOT NULL,
  `bookedOn` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `isValid` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Vheicles table';

--
-- Дамп данных таблицы `cars`
--

INSERT INTO `cars` (`id`, `vin`, `nick`, `plate`, `region`, `model_id`, `bookedOn`, `isValid`) VALUES
(1, 'bmbxxlw8w88006652', 'Fifer', 'x980xx', 78, 1, '2018-09-14 09:10:35', 1);

-- --------------------------------------------------------

--
-- Структура таблицы `city`
--

CREATE TABLE `city` (
  `id` int(11) NOT NULL,
  `name` varchar(16) NOT NULL,
  `name_en` varchar(16) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `city`
--

INSERT INTO `city` (`id`, `name`, `name_en`) VALUES
(1, 'Москва', 'Moscow'),
(2, 'СПб', 'Saint-Petersburg'),
(3, 'Луга', 'Luga'),
(4, 'Дно', 'Dno');

-- --------------------------------------------------------

--
-- Структура таблицы `currency`
--

CREATE TABLE `currency` (
  `id` int(11) NOT NULL,
  `name` varchar(8) NOT NULL,
  `name_en` varchar(8) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Currencies';

--
-- Дамп данных таблицы `currency`
--

INSERT INTO `currency` (`id`, `name`, `name_en`) VALUES
(1, 'Руб.', 'RUR'),
(2, 'Дол.', 'USD'),
(3, 'Евро', 'EUR');

-- --------------------------------------------------------

--
-- Структура таблицы `fuel_grades`
--

CREATE TABLE `fuel_grades` (
  `id` int(11) NOT NULL,
  `name` varchar(6) NOT NULL,
  `name_en` varchar(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `fuel_grades`
--

INSERT INTO `fuel_grades` (`id`, `name`, `name_en`) VALUES
(1, 'Аи80', '80'),
(2, 'Аи92', '92'),
(3, 'Аи92+', '92+'),
(4, 'Аи95', '95'),
(5, 'Аи95+', '95+'),
(6, 'Аи98 ', '98'),
(7, 'Аи98+', '98+'),
(8, 'Аи100', '100'),
(9, 'ДТ+', 'Disel'),
(10, 'ДТ ЕВР', 'DiselE'),
(11, 'Пропан', 'Gas');

-- --------------------------------------------------------

--
-- Структура таблицы `fuel_journal`
--

CREATE TABLE `fuel_journal` (
  `id` int(11) NOT NULL,
  `car_id` int(11) NOT NULL,
  `grade_id` int(11) NOT NULL,
  `qty` decimal(9,2) NOT NULL,
  `mu_id` int(11) NOT NULL,
  `price` decimal(9,2) NOT NULL,
  `cur_id` int(11) NOT NULL,
  `location_id` int(11) NOT NULL,
  `filledOn` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `bookedOn` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `isValid` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Fuel consumption ledger';

--
-- Дамп данных таблицы `fuel_journal`
--

INSERT INTO `fuel_journal` (`id`, `car_id`, `grade_id`, `qty`, `mu_id`, `price`, `cur_id`, `location_id`, `filledOn`, `bookedOn`, `isValid`) VALUES
(1, 1, 4, '20.00', 3, '860.00', 1, 6, '2018-08-12 14:49:00', '2018-09-15 11:24:25', 1),
(3, 1, 4, '21.72', 3, '943.73', 1, 7, '2018-09-05 18:44:00', '2018-09-15 11:30:00', 1),
(4, 1, 4, '30.00', 3, '1323.00', 1, 4, '2018-08-25 15:17:00', '2018-09-15 12:26:36', 1),
(5, 1, 4, '20.00', 3, '872.00', 1, 5, '2018-08-10 19:49:00', '2018-09-15 12:28:33', 1),
(6, 1, 4, '30.00', 3, '1290.00', 1, 3, '2018-09-10 17:09:00', '2018-09-15 12:30:21', 1),
(7, 1, 4, '20.00', 3, '866.00', 1, 2, '2018-08-12 11:16:00', '2018-09-15 12:32:02', 1);

-- --------------------------------------------------------

--
-- Структура таблицы `locations`
--

CREATE TABLE `locations` (
  `id` int(11) NOT NULL,
  `name` varchar(24) NOT NULL,
  `address` varchar(48) NOT NULL,
  `phone` bigint(11) DEFAULT NULL,
  `city_id` int(11) NOT NULL,
  `type_id` int(11) NOT NULL,
  `owner_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='General locations list';

--
-- Дамп данных таблицы `locations`
--

INSERT INTO `locations` (`id`, `name`, `address`, `phone`, `city_id`, `type_id`, `owner_id`) VALUES
(1, 'АЗС №160', 'Благодатная ул., 10А', 4591660, 2, 1, 1),
(2, 'МАЗС-75', 'Пригородный', 0, 4, 1, 9),
(3, 'АЗС-31', 'Витебский пр.153', 9213117835, 2, 1, 7),
(4, 'АЗС-13', 'Русско-Высоцкое д.1', 9219897477, 2, 1, 7),
(5, 'АЗС-224', 'Ленинградское ш.32', 8137222819, 3, 1, 7),
(6, 'АЗС-212', 'Рождествено', 9210950798, 2, 1, 7),
(7, 'Circle Шушары', 'Витебский д.130', 8005554647, 2, 1, 8);

-- --------------------------------------------------------

--
-- Структура таблицы `loc_types`
--

CREATE TABLE `loc_types` (
  `id` int(11) NOT NULL,
  `name` varchar(24) NOT NULL,
  `name_en` varchar(24) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Classification of locations';

--
-- Дамп данных таблицы `loc_types`
--

INSERT INTO `loc_types` (`id`, `name`, `name_en`) VALUES
(1, 'АЗС', 'Gasoline'),
(2, 'Мойка', 'Car wash'),
(3, 'Станция ТО', 'Service Station'),
(4, 'Шиномонтаж', 'Tire workshop');

-- --------------------------------------------------------

--
-- Структура таблицы `material_class`
--

CREATE TABLE `material_class` (
  `id` int(11) NOT NULL,
  `name` varchar(24) NOT NULL,
  `name_en` varchar(24) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Classes of materials';

--
-- Дамп данных таблицы `material_class`
--

INSERT INTO `material_class` (`id`, `name`, `name_en`) VALUES
(1, 'Масло моторное', 'Engine oil'),
(2, 'Масло к/п', 'Gear oil'),
(3, 'Тормозная жид.', 'Brake fluid'),
(4, 'Колодки тормозные', 'Brake pads'),
(5, 'Бензин', 'Gasoline');

-- --------------------------------------------------------

--
-- Структура таблицы `material_items`
--

CREATE TABLE `material_items` (
  `id` int(11) NOT NULL,
  `name` varchar(16) NOT NULL,
  `class_id` int(11) NOT NULL,
  `manuf_by_id` int(11) NOT NULL,
  `snum` varchar(24) NOT NULL,
  `price` int(11) NOT NULL,
  `currency_id` int(11) NOT NULL,
  `qty` int(11) NOT NULL,
  `mu_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `material_items`
--

INSERT INTO `material_items` (`id`, `name`, `class_id`, `manuf_by_id`, `snum`, `price`, `currency_id`, `qty`, `mu_id`) VALUES
(1, 'Genesis', 1, 1, '', 3000, 1, 4, 3);

-- --------------------------------------------------------

--
-- Структура таблицы `models`
--

CREATE TABLE `models` (
  `id` int(11) NOT NULL,
  `brand_id` int(11) NOT NULL,
  `name` varchar(24) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Model of car';

--
-- Дамп данных таблицы `models`
--

INSERT INTO `models` (`id`, `brand_id`, `name`) VALUES
(1, 1, 'X5'),
(2, 1, 'X3');

-- --------------------------------------------------------

--
-- Структура таблицы `mu`
--

CREATE TABLE `mu` (
  `id` int(11) NOT NULL,
  `name` varchar(16) NOT NULL,
  `name_en` varchar(16) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='measurement units';

--
-- Дамп данных таблицы `mu`
--

INSERT INTO `mu` (`id`, `name`, `name_en`) VALUES
(1, 'Км', 'Km'),
(2, 'Миля', 'Mile'),
(3, 'Литр', 'Liter');

-- --------------------------------------------------------

--
-- Структура таблицы `oil_attributes`
--

CREATE TABLE `oil_attributes` (
  `id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `cat_id` int(11) NOT NULL COMMENT 'Category',
  `visc_winter_id` int(11) NOT NULL COMMENT 'Viscosity WINTER',
  `visc_summer_id` int(11) NOT NULL COMMENT 'Summer'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Attributes of the given oil item';

--
-- Дамп данных таблицы `oil_attributes`
--

INSERT INTO `oil_attributes` (`id`, `item_id`, `cat_id`, `visc_winter_id`, `visc_summer_id`) VALUES
(1, 1, 2, 2, 8);

-- --------------------------------------------------------

--
-- Структура таблицы `oil_categories`
--

CREATE TABLE `oil_categories` (
  `id` int(11) NOT NULL,
  `name` varchar(2) NOT NULL,
  `year` smallint(4) NOT NULL,
  `isValid` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Oil Category by API';

--
-- Дамп данных таблицы `oil_categories`
--

INSERT INTO `oil_categories` (`id`, `name`, `year`, `isValid`) VALUES
(1, 'SJ', 2001, 1),
(2, 'SL', 2004, 1),
(3, 'SM', 2010, 1),
(4, 'SN', 9999, 1),
(5, 'SG', 1993, 0),
(6, 'SH', 1996, 0),
(7, 'SE', 1979, 0),
(8, 'SF', 1988, 0);

-- --------------------------------------------------------

--
-- Структура таблицы `oil_visc`
--

CREATE TABLE `oil_visc` (
  `id` int(11) NOT NULL,
  `value` tinyint(4) NOT NULL,
  `season` tinyint(1) NOT NULL COMMENT '0 - winter 1 - summer',
  `temperature` tinyint(4) DEFAULT NULL COMMENT 'For winter grades'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Oil lubricant viscosities ';

--
-- Дамп данных таблицы `oil_visc`
--

INSERT INTO `oil_visc` (`id`, `value`, `season`, `temperature`) VALUES
(1, 0, 0, 35),
(2, 5, 0, 30),
(3, 10, 0, 25),
(4, 15, 0, 20),
(5, 20, 0, 15),
(6, 25, 0, 10),
(7, 20, 1, 0),
(8, 30, 1, 0),
(9, 40, 1, NULL),
(10, 50, 1, NULL),
(11, 60, 1, NULL);

-- --------------------------------------------------------

--
-- Структура таблицы `put_on`
--

CREATE TABLE `put_on` (
  `id` int(11) NOT NULL,
  `car_id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `svs_id` int(11) NOT NULL COMMENT 'Reference to relevant service',
  `bookedOn` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `isValid` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Put your hat on (your car): installed gear';

--
-- Дамп данных таблицы `put_on`
--

INSERT INTO `put_on` (`id`, `car_id`, `item_id`, `svs_id`, `bookedOn`, `isValid`) VALUES
(1, 1, 1, 1, '2018-09-15 10:13:34', 1);

-- --------------------------------------------------------

--
-- Структура таблицы `road_meter`
--

CREATE TABLE `road_meter` (
  `id` int(11) NOT NULL,
  `car_id` int(11) NOT NULL,
  `qty` int(11) NOT NULL,
  `mu_id` int(11) NOT NULL,
  `bookedOn` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `isValid` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Car mileage journal';

--
-- Дамп данных таблицы `road_meter`
--

INSERT INTO `road_meter` (`id`, `car_id`, `qty`, `mu_id`, `bookedOn`, `isValid`) VALUES
(1, 1, 30000, 1, '2018-09-14 10:28:23', 1),
(2, 1, 30001, 1, '2018-09-14 10:38:38', 1),
(3, 1, 30067, 1, '2018-09-15 10:25:58', 1);

-- --------------------------------------------------------

--
-- Структура таблицы `service_class`
--

CREATE TABLE `service_class` (
  `id` int(11) NOT NULL,
  `name` varchar(24) NOT NULL,
  `name_en` varchar(24) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `service_class`
--

INSERT INTO `service_class` (`id`, `name`, `name_en`) VALUES
(1, 'Замена масла в двиг.', 'Engine oil refill'),
(2, 'Шиномонтаж', 'Change of tires'),
(3, 'Замена тормозных колодок', 'Brake pads change');

-- --------------------------------------------------------

--
-- Структура таблицы `service_journal`
--

CREATE TABLE `service_journal` (
  `id` int(11) NOT NULL,
  `car_id` int(11) NOT NULL,
  `svs_class_id` int(11) NOT NULL,
  `location_id` int(11) NOT NULL,
  `price` int(11) NOT NULL,
  `cur_id` int(11) NOT NULL COMMENT 'currency',
  `doneOn` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `bookedOn` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `isValid` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Service ledger';

--
-- Дамп данных таблицы `service_journal`
--

INSERT INTO `service_journal` (`id`, `car_id`, `svs_class_id`, `location_id`, `price`, `cur_id`, `doneOn`, `bookedOn`, `isValid`) VALUES
(1, 1, 1, 1, 5500, 1, '2018-09-15 09:46:48', '2018-09-15 09:46:48', 1);

-- --------------------------------------------------------

--
-- Структура таблицы `vendors`
--

CREATE TABLE `vendors` (
  `id` int(11) NOT NULL,
  `name` varchar(24) NOT NULL,
  `name_en` varchar(24) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `vendors`
--

INSERT INTO `vendors` (`id`, `name`, `name_en`) VALUES
(1, 'Лукойл', 'Lukoil'),
(2, 'Газпромнефть', 'Gazpromneft'),
(3, 'Shell', 'Shell'),
(4, 'BP', 'BP'),
(5, 'Mobil', 'Mobil'),
(6, 'Castrol', 'Castrol'),
(7, 'Киришиавтосервис', 'KirishiAvtoService'),
(8, 'Серкл Кей', 'Circle Key'),
(9, 'Псковнефтепродукт', 'Pskownefteproduct');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `brands`
--
ALTER TABLE `brands`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `cars`
--
ALTER TABLE `cars`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `city`
--
ALTER TABLE `city`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `currency`
--
ALTER TABLE `currency`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `fuel_grades`
--
ALTER TABLE `fuel_grades`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `fuel_journal`
--
ALTER TABLE `fuel_journal`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `locations`
--
ALTER TABLE `locations`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `loc_types`
--
ALTER TABLE `loc_types`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `material_class`
--
ALTER TABLE `material_class`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `material_items`
--
ALTER TABLE `material_items`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `models`
--
ALTER TABLE `models`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `mu`
--
ALTER TABLE `mu`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `oil_attributes`
--
ALTER TABLE `oil_attributes`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `item_id` (`item_id`);

--
-- Индексы таблицы `oil_categories`
--
ALTER TABLE `oil_categories`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `oil_visc`
--
ALTER TABLE `oil_visc`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `put_on`
--
ALTER TABLE `put_on`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `road_meter`
--
ALTER TABLE `road_meter`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `service_class`
--
ALTER TABLE `service_class`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `service_journal`
--
ALTER TABLE `service_journal`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `vendors`
--
ALTER TABLE `vendors`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `brands`
--
ALTER TABLE `brands`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT для таблицы `cars`
--
ALTER TABLE `cars`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT для таблицы `city`
--
ALTER TABLE `city`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT для таблицы `currency`
--
ALTER TABLE `currency`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT для таблицы `fuel_grades`
--
ALTER TABLE `fuel_grades`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT для таблицы `fuel_journal`
--
ALTER TABLE `fuel_journal`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT для таблицы `locations`
--
ALTER TABLE `locations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT для таблицы `loc_types`
--
ALTER TABLE `loc_types`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT для таблицы `material_class`
--
ALTER TABLE `material_class`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT для таблицы `material_items`
--
ALTER TABLE `material_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT для таблицы `models`
--
ALTER TABLE `models`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT для таблицы `mu`
--
ALTER TABLE `mu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT для таблицы `oil_attributes`
--
ALTER TABLE `oil_attributes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT для таблицы `oil_categories`
--
ALTER TABLE `oil_categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT для таблицы `oil_visc`
--
ALTER TABLE `oil_visc`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT для таблицы `put_on`
--
ALTER TABLE `put_on`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT для таблицы `road_meter`
--
ALTER TABLE `road_meter`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT для таблицы `service_class`
--
ALTER TABLE `service_class`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT для таблицы `service_journal`
--
ALTER TABLE `service_journal`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT для таблицы `vendors`
--
ALTER TABLE `vendors`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
