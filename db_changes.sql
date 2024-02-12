CREATE TABLE `zymos` (
  `id` int(10) UNSIGNED NOT NULL,
  `zyma` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `kiek_kartojasi` int(10) UNSIGNED NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

ALTER TABLE `zymos`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `zyma` (`zyma`);
