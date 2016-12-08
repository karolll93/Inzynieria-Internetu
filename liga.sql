
-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `awanse`
--

CREATE TABLE `awanse` (
  `ag_id` int(10) NOT NULL,
  `ag_rozgrywka` int(10) NOT NULL,
  `ag_klub` int(10) NOT NULL,
  `ag_zysk` int(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `gole`
--

CREATE TABLE `gole` (
  `g_id` int(10) NOT NULL,
  `g_min` int(3) DEFAULT NULL,
  `g_typ` varchar(10) COLLATE utf8_polish_ci DEFAULT NULL,
  `g_mecz` int(10) NOT NULL,
  `g_kzaw` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Zrzut danych tabeli `gole`
--

INSERT INTO `gole` (`g_id`, `g_min`, `g_typ`, `g_mecz`, `g_kzaw`) VALUES
(3, 58, 'karny', 1, 1),
(4, 24, '', 1, 2),
(5, 76, '', 1, 2),
(6, 42, '', 6, 7),
(7, 0, '', 6, 8),
(8, 0, '', 6, 8),
(9, 0, '', 6, 8);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `kluby`
--

CREATE TABLE `kluby` (
  `k_id` int(10) NOT NULL,
  `k_nazwa` varchar(100) COLLATE utf8_polish_ci NOT NULL,
  `k_panstwo` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Zrzut danych tabeli `kluby`
--

INSERT INTO `kluby` (`k_id`, `k_nazwa`, `k_panstwo`) VALUES
(1, 'Arsenal Londyn', 1),
(2, 'Manchester City', 1),
(3, 'Real Madryt', 3),
(5, 'Chelsea Londyn', 1),
(6, 'Bayern Monachium', 4),
(7, 'FC Barcelona', 3),
(8, 'Atletico Madryt', 3),
(10, 'Borussia Dortmund', 4),
(11, 'PSV Eindhoven', 5),
(12, 'Legia Warszawa', 2),
(13, 'Sporting Lizbona', 9);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `klub_zawodnicy`
--

CREATE TABLE `klub_zawodnicy` (
  `kzaw_id` int(10) NOT NULL,
  `kzaw_zaw` int(10) NOT NULL,
  `kzaw_klub` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Zrzut danych tabeli `klub_zawodnicy`
--

INSERT INTO `klub_zawodnicy` (`kzaw_id`, `kzaw_zaw`, `kzaw_klub`) VALUES
(4, 2, 2),
(1, 3, 1),
(5, 4, 2),
(3, 6, 3),
(2, 8, 1),
(6, 10, 7),
(7, 11, 7),
(8, 12, 7);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `mecze`
--

CREATE TABLE `mecze` (
  `m_id` int(10) NOT NULL,
  `m_data` date NOT NULL,
  `m_miejsce` varchar(200) COLLATE utf8_polish_ci NOT NULL,
  `m_rozegrany` char(1) COLLATE utf8_polish_ci DEFAULT NULL,
  `m_bramki1` int(2) DEFAULT NULL,
  `m_bramki2` int(2) DEFAULT NULL,
  `m_widzow` int(6) DEFAULT NULL,
  `m_sedzia` varchar(100) COLLATE utf8_polish_ci DEFAULT NULL,
  `m_gospodarz` int(10) NOT NULL,
  `m_gosc` int(10) NOT NULL,
  `m_rozgrywka` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Zrzut danych tabeli `mecze`
--

INSERT INTO `mecze` (`m_id`, `m_data`, `m_miejsce`, `m_rozegrany`, `m_bramki1`, `m_bramki2`, `m_widzow`, `m_sedzia`, `m_gospodarz`, `m_gosc`, `m_rozgrywka`) VALUES
(1, '2016-09-24', 'Emirates Stadium', 't', 3, 0, 0, 'Michael Oliver', 1, 2, 3),
(2, '2016-12-18', '', 'n', NULL, NULL, 0, '', 3, 1, 3),
(3, '2016-12-03', '', 'n', NULL, NULL, 0, '', 2, 3, 3),
(4, '2016-10-18', '', 't', 5, 1, 0, '', 9, 8, 2),
(5, '2016-11-02', '', 't', 3, 3, 0, '', 8, 9, 2),
(6, '2016-11-22', 'Signal Iduna Park', 't', 8, 4, 0, '', 7, 8, 2),
(7, '2016-09-14', '', 't', 0, 6, 0, '', 8, 7, 2);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `mecz_klub_statystyki`
--

CREATE TABLE `mecz_klub_statystyki` (
  `mks_id` int(10) NOT NULL,
  `mks_zkartki` int(2) DEFAULT NULL,
  `mks_ckartki` int(2) DEFAULT NULL,
  `mks_posiadanie` int(3) DEFAULT NULL,
  `mks_spalone` int(3) DEFAULT NULL,
  `mks_faule` int(3) DEFAULT NULL,
  `mks_rozne` int(3) DEFAULT NULL,
  `mks_mecz` int(10) NOT NULL,
  `mks_rklub` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `panstwa`
--

CREATE TABLE `panstwa` (
  `p_id` int(10) NOT NULL,
  `p_nazwa` varchar(100) COLLATE utf8_polish_ci NOT NULL,
  `p_skrot` varchar(10) COLLATE utf8_polish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Zrzut danych tabeli `panstwa`
--

INSERT INTO `panstwa` (`p_id`, `p_nazwa`, `p_skrot`) VALUES
(1, 'Anglia', 'ANG'),
(2, 'Polska', 'POL'),
(3, 'Hiszpania', 'HIS'),
(4, 'Niemcy', 'NIE'),
(5, 'Holandia', 'HOL'),
(6, 'Argentyna', 'ARG'),
(7, 'Włochy', 'ITA'),
(8, 'Francja', 'FRA'),
(9, 'Portugalia', 'POR');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `rozgrywka_kluby`
--

CREATE TABLE `rozgrywka_kluby` (
  `rk_id` int(10) NOT NULL,
  `rk_roz` int(10) NOT NULL,
  `rk_klub` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Zrzut danych tabeli `rozgrywka_kluby`
--

INSERT INTO `rozgrywka_kluby` (`rk_id`, `rk_roz`, `rk_klub`) VALUES
(9, 2, 3),
(7, 2, 10),
(8, 2, 12),
(10, 2, 13),
(1, 3, 1),
(3, 3, 2),
(2, 3, 5),
(4, 4, 1),
(6, 4, 2),
(5, 4, 5);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `rozgrywki`
--

CREATE TABLE `rozgrywki` (
  `roz_id` int(10) NOT NULL,
  `roz_liga` varchar(50) COLLATE utf8_polish_ci NOT NULL,
  `roz_typ` varchar(20) COLLATE utf8_polish_ci NOT NULL,
  `roz_nazwa` varchar(100) COLLATE utf8_polish_ci NOT NULL,
  `roz_sezon` varchar(9) COLLATE utf8_polish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Zrzut danych tabeli `rozgrywki`
--

INSERT INTO `rozgrywki` (`roz_id`, `roz_liga`, `roz_typ`, `roz_nazwa`, `roz_sezon`) VALUES
(1, 'Liga Mistrzów', 'grupa', 'Grupa A', '2016/2017'),
(2, 'Liga Mistrzów', 'grupa', 'Grupa F', '2016/2017'),
(3, 'Liga angielska', 'liga', 'Premiership', '2016/2017'),
(4, 'Liga angielska', 'liga', 'Premiership', '2015/2016'),
(5, 'Liga Europejska', 'grupa', 'Grupa A', '2016/2017');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `uzytkownicy`
--

CREATE TABLE `uzytkownicy` (
  `id` int(10) NOT NULL,
  `login` varchar(32) COLLATE utf8_polish_ci NOT NULL,
  `haslo` varchar(64) COLLATE utf8_polish_ci NOT NULL,
  `admin` tinyint(1) NOT NULL DEFAULT '0',
  `remember_token` varchar(255) COLLATE utf8_polish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Zrzut danych tabeli `uzytkownicy`
--

INSERT INTO `uzytkownicy` (`id`, `login`, `haslo`, `admin`, `remember_token`) VALUES
(1, 'admin', '$2y$10$Yvf5Ne8nmvxWbSNbr3AJke7HJepyvsmZAurEauYrgF9MCjeFsgVNO', 1, '8JxKMdnAOSM4404DQL79y5qCSehY3QeJq1yers79jpcw05HG92sncoDDli6P');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `zawodnicy`
--

CREATE TABLE `zawodnicy` (
  `z_id` int(10) NOT NULL,
  `z_imie` varchar(30) COLLATE utf8_polish_ci NOT NULL,
  `z_nazwisko` varchar(30) COLLATE utf8_polish_ci NOT NULL,
  `z_panstwo` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Zrzut danych tabeli `zawodnicy`
--

INSERT INTO `zawodnicy` (`z_id`, `z_imie`, `z_nazwisko`, `z_panstwo`) VALUES
(1, 'Robert', 'Lewandowski', 2),
(2, 'Diego', 'Costa', 3),
(3, 'Santi', 'Cazorla', 3),
(4, 'Cesc', 'Fabregas', 3),
(5, 'Leo', 'Messi', 2),
(6, 'Sergio', 'Aguero', 6),
(7, 'David', 'Silva', 3),
(8, 'Mesut', 'Ozil', 4),
(10, 'Łukasz', 'Piszczek', 2),
(11, 'Mario', 'Goetze', 4),
(12, 'Marco', 'Reus', 4);

--
-- Indeksy dla zrzutów tabel
--

--
-- Indexes for table `awanse`
--
ALTER TABLE `awanse`
  ADD PRIMARY KEY (`ag_id`),
  ADD KEY `AWANS_KLUB_FK` (`ag_klub`),
  ADD KEY `AWANS_ROZGRYWKA_FK` (`ag_rozgrywka`);

--
-- Indexes for table `gole`
--
ALTER TABLE `gole`
  ADD PRIMARY KEY (`g_id`),
  ADD KEY `GOL_KLUB_ZAWODNIK_FK` (`g_kzaw`),
  ADD KEY `GOL_MECZ_FK` (`g_mecz`);

--
-- Indexes for table `kluby`
--
ALTER TABLE `kluby`
  ADD PRIMARY KEY (`k_id`),
  ADD KEY `KLUB_PANSTWO_FK` (`k_panstwo`);

--
-- Indexes for table `klub_zawodnicy`
--
ALTER TABLE `klub_zawodnicy`
  ADD PRIMARY KEY (`kzaw_id`),
  ADD UNIQUE KEY `kzaw_zaw` (`kzaw_zaw`,`kzaw_klub`),
  ADD KEY `KLUB_ZAWODNIK_ROZGRYWKA_KLUB_FK` (`kzaw_klub`),
  ADD KEY `KLUB_ZAWODNIK_ZAWODNIK_FK` (`kzaw_zaw`);

--
-- Indexes for table `mecze`
--
ALTER TABLE `mecze`
  ADD PRIMARY KEY (`m_id`),
  ADD KEY `MECZ_ROZGRYWKA_FK` (`m_rozgrywka`),
  ADD KEY `MECZ_ROZGRYWKA_KLUB_FK` (`m_gospodarz`),
  ADD KEY `MECZ_ROZGRYWKA_KLUB_FKv1` (`m_gosc`);

--
-- Indexes for table `mecz_klub_statystyki`
--
ALTER TABLE `mecz_klub_statystyki`
  ADD PRIMARY KEY (`mks_id`),
  ADD KEY `MECZ_KLUB_STATYSTYKA_MECZ_FK` (`mks_mecz`),
  ADD KEY `MECZ_KLUB_STATYSTYKA_ROZGRYWKA_KLUB_FK` (`mks_rklub`);

--
-- Indexes for table `panstwa`
--
ALTER TABLE `panstwa`
  ADD PRIMARY KEY (`p_id`);

--
-- Indexes for table `rozgrywka_kluby`
--
ALTER TABLE `rozgrywka_kluby`
  ADD PRIMARY KEY (`rk_id`),
  ADD UNIQUE KEY `rk_roz` (`rk_roz`,`rk_klub`),
  ADD KEY `ROZGRYWKA_KLUB_KLUB_FK` (`rk_klub`),
  ADD KEY `ROZGRYWKA_KLUB_ROZGRYWKA_FK` (`rk_roz`);

--
-- Indexes for table `rozgrywki`
--
ALTER TABLE `rozgrywki`
  ADD PRIMARY KEY (`roz_id`);

--
-- Indexes for table `uzytkownicy`
--
ALTER TABLE `uzytkownicy`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `login` (`login`);

--
-- Indexes for table `zawodnicy`
--
ALTER TABLE `zawodnicy`
  ADD PRIMARY KEY (`z_id`),
  ADD KEY `ZAWODNIK_PAŃSTWO_FK` (`z_panstwo`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT dla tabeli `awanse`
--
ALTER TABLE `awanse`
  MODIFY `ag_id` int(10) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT dla tabeli `gole`
--
ALTER TABLE `gole`
  MODIFY `g_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT dla tabeli `kluby`
--
ALTER TABLE `kluby`
  MODIFY `k_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
--
-- AUTO_INCREMENT dla tabeli `klub_zawodnicy`
--
ALTER TABLE `klub_zawodnicy`
  MODIFY `kzaw_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT dla tabeli `mecze`
--
ALTER TABLE `mecze`
  MODIFY `m_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT dla tabeli `mecz_klub_statystyki`
--
ALTER TABLE `mecz_klub_statystyki`
  MODIFY `mks_id` int(10) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT dla tabeli `panstwa`
--
ALTER TABLE `panstwa`
  MODIFY `p_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT dla tabeli `rozgrywka_kluby`
--
ALTER TABLE `rozgrywka_kluby`
  MODIFY `rk_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT dla tabeli `rozgrywki`
--
ALTER TABLE `rozgrywki`
  MODIFY `roz_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT dla tabeli `uzytkownicy`
--
ALTER TABLE `uzytkownicy`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT dla tabeli `zawodnicy`
--
ALTER TABLE `zawodnicy`
  MODIFY `z_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
--
-- Ograniczenia dla zrzutów tabel
--

--
-- Ograniczenia dla tabeli `awanse`
--
ALTER TABLE `awanse`
  ADD CONSTRAINT `AWANS_KLUB_FK` FOREIGN KEY (`ag_klub`) REFERENCES `kluby` (`k_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `AWANS_ROZGRYWKA_FK` FOREIGN KEY (`ag_rozgrywka`) REFERENCES `rozgrywki` (`roz_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ograniczenia dla tabeli `gole`
--
ALTER TABLE `gole`
  ADD CONSTRAINT `GOL_KLUB_ZAWODNIK_FK` FOREIGN KEY (`g_kzaw`) REFERENCES `klub_zawodnicy` (`kzaw_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `GOL_MECZ_FK` FOREIGN KEY (`g_mecz`) REFERENCES `mecze` (`m_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ograniczenia dla tabeli `kluby`
--
ALTER TABLE `kluby`
  ADD CONSTRAINT `KLUB_PANSTWO_FK` FOREIGN KEY (`k_panstwo`) REFERENCES `panstwa` (`p_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ograniczenia dla tabeli `klub_zawodnicy`
--
ALTER TABLE `klub_zawodnicy`
  ADD CONSTRAINT `KLUB_ZAWODNIK_ROZGRYWKA_KLUB_FK` FOREIGN KEY (`kzaw_klub`) REFERENCES `rozgrywka_kluby` (`rk_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `KLUB_ZAWODNIK_ZAWODNIK_FK` FOREIGN KEY (`kzaw_zaw`) REFERENCES `zawodnicy` (`z_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ograniczenia dla tabeli `mecze`
--
ALTER TABLE `mecze`
  ADD CONSTRAINT `MECZ_ROZGRYWKA_FK` FOREIGN KEY (`m_rozgrywka`) REFERENCES `rozgrywki` (`roz_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `MECZ_ROZGRYWKA_KLUB_FK` FOREIGN KEY (`m_gospodarz`) REFERENCES `rozgrywka_kluby` (`rk_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `MECZ_ROZGRYWKA_KLUB_FKv1` FOREIGN KEY (`m_gosc`) REFERENCES `rozgrywka_kluby` (`rk_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ograniczenia dla tabeli `mecz_klub_statystyki`
--
ALTER TABLE `mecz_klub_statystyki`
  ADD CONSTRAINT `MECZ_KLUB_STATYSTYKA_MECZ_FK` FOREIGN KEY (`mks_mecz`) REFERENCES `mecze` (`m_id`),
  ADD CONSTRAINT `MECZ_KLUB_STATYSTYKA_ROZGRYWKA_KLUB_FK` FOREIGN KEY (`mks_rklub`) REFERENCES `rozgrywka_kluby` (`rk_id`);

--
-- Ograniczenia dla tabeli `rozgrywka_kluby`
--
ALTER TABLE `rozgrywka_kluby`
  ADD CONSTRAINT `ROZGRYWKA_KLUB_KLUB_FK` FOREIGN KEY (`rk_klub`) REFERENCES `kluby` (`k_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `ROZGRYWKA_KLUB_ROZGRYWKA_FK` FOREIGN KEY (`rk_roz`) REFERENCES `rozgrywki` (`roz_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ograniczenia dla tabeli `zawodnicy`
--
ALTER TABLE `zawodnicy`
  ADD CONSTRAINT `ZAWODNIK_PANSTWO_FK` FOREIGN KEY (`z_panstwo`) REFERENCES `panstwa` (`p_id`) ON DELETE CASCADE ON UPDATE CASCADE;
