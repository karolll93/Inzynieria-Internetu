<?php

if (isset($_GET['akcja']) && $_GET['akcja'] == "dodaj") {
	echo "<h1>Dodanie zawodnika</h1>\n";
	
		if (isset($_POST['dodaj'])) {
			if (!empty($_POST['z_imie']) && !empty($_POST['z_nazwisko']) && !empty($_POST['z_panstwo'])) {
				$insert = mysql_query("INSERT INTO zawodnicy (z_imie, z_nazwisko, z_panstwo) VALUES ('".$_POST['z_imie']."', '".$_POST['z_nazwisko']."', '".$_POST['z_panstwo']."')");
				echo "<div class='success'>Zawodnik został dodany! Teraz możesz dodać następnego!</div>\n";
			} else {
				echo "<div class='error'>Imię, nazwisko oraz państwo są obowiązkowe!</div>\n";
			}
		}
		if (!isset($_POST['z_nazwisko'])) $_POST['z_nazwisko'] = "";
		if (!isset($_POST['z_imie'])) $_POST['z_imie'] = "";
		if (!isset($_POST['k_panstwo'])) $_POST['k_panstwo'] = "";
		echo "<form action='index.php?amodul=zawodnicy&amp;akcja=dodaj' method='post'>\n";
		echo "<table>";
		echo "<tr><td>Imię:</td><td><input type='text' name='z_imie' maxlength='30' value='".$_POST['z_imie']."' /></td></tr>\n";
		echo "<tr><td>Nazwisko:</td><td><input type='text' name='z_nazwisko' maxlength='30' value='".$_POST['z_nazwisko']."' /></td></tr>\n";
		echo "<tr><td>Państwo:</td><td><select name='z_panstwo'>";
		$panstwa = mysql_query("SELECT * FROM państwa ORDER by p_nazwa");
		while ($p = mysql_fetch_array($panstwa)) {
			if ($_POST['z_panstwo'] == $p['p_id']) {
				echo "<option value='".$p['p_id']."' selected='selected'>".$p['p_nazwa']."</option>\n";
			} else {
				echo "<option value='".$p['p_id']."'>".$p['p_nazwa']."</option>\n";
			}
		}
		echo "</td></tr>\n";
		echo "<tr><td colspan='2'><input type='submit' name='dodaj' value='dodaj' /></td></tr>\n";
		echo "</table>\n";
		echo "</form>\n";

} else if (isset($_GET['akcja']) && $_GET['akcja'] == "edytuj" && isset($_GET['id'])) {
	$id = $_GET['id'];
	$zawodnik = mysql_fetch_array(mysql_query("SELECT * FROM zawodnicy WHERE z_id = '".$id."' LIMIT 1"));
	if ($zawodnik) {
		echo "<h1>Edycja zawodnika</h1>\n";
		
		if (isset($_POST['zapisz']) && !empty($_POST['z_imie']) && !empty($_POST['z_nazwisko']) && !empty($_POST['z_panstwo'])) {
			$zapisz = mysql_query("UPDATE zawodnicy SET z_imie = '".$_POST['z_imie']."', z_nazwisko = '".$_POST['z_nazwisko']."', z_panstwo = '".$_POST['z_panstwo']."' WHERE z_id = '".$id."' LIMIT 1");
			echo "<div class='success'>Zapisano zmiany!</div>\n";
			$zawodnik = mysql_fetch_array(mysql_query("SELECT * FROM zawodnicy WHERE z_id = '".$id."' LIMIT 1"));
		}
		
		echo "<form action='index.php?amodul=zawodnicy&amp;akcja=edytuj&amp;id=".$id."' method='post'>\n";
		echo "<table>";
		echo "<tr><td>Imię:</td><td><input type='text' name='z_imie' maxlength='30' value='".$zawodnik['z_imie']."' /></td></tr>\n";
		echo "<tr><td>Nazwisko:</td><td><input type='text' name='z_nazwisko' maxlength='30' value='".$zawodnik['z_nazwisko']."' /></td></tr>\n";
		echo "<tr><td>Państwo:</td><td><select name='z_panstwo'>";
		$panstwa = mysql_query("SELECT * FROM państwa ORDER by p_nazwa");
		while ($p = mysql_fetch_array($panstwa)) {
			if ($zawodnik['z_panstwo'] == $p['p_id']) {
				echo "<option value='".$p['p_id']."' selected='selected'>".$p['p_nazwa']."</option>\n";
			} else {
				echo "<option value='".$p['p_id']."'>".$p['p_nazwa']."</option>\n";
			}
		}
		echo "</td></tr>\n";
		echo "<tr><td colspan='2'><input type='submit' name='zapisz' value='zapisz zmiany' /></td></tr>\n";
		echo "</table>\n";
		echo "</form>\n";
	}
} else {
	echo "<h1>Zarządzanie zawodnikami</h1>\n";
	
	if (isset($_GET['akcja']) && $_GET['akcja'] == "usun" && isset($_GET['id'])) {
		$id = $_GET['id'];
		$delete = mysql_query("DELETE FROM zawodnicy WHERE z_id = '".$id."' LIMIT 1");
		if ($delete) {
			echo "<div class='success'>Wybrany zawodnik został usunięty!</div>\n";
		} else {
			echo "<div class='error'>".mysql_error()."</div>\n";
		}
	}
	
	echo "<div class='center'><a href='index.php?amodul=zawodnicy&amp;akcja=dodaj'>dodaj zawodnika</a></div>\n";
	
	$zawodnicy = mysql_query("SELECT * FROM zawodnicy z JOIN państwa p ON z.z_panstwo=p.p_id ORDER by z_nazwisko, z_imie");

	echo "<table>\n";
	echo "<tr class='first'><td>Imię</td><td>Nazwisko</td><td>Państwo</td><td>Opcje</td></tr>\n";
	$i = 1;
	while ($z = mysql_fetch_array($zawodnicy)) {
		echo "<tr>\n";
	
		echo "<td>".$z['z_imie']."</td>\n";

		echo "<td>".$z['z_nazwisko']."</td>\n";		
	
		echo "<td>".$z['p_nazwa']."</td>\n";
		
		echo "<td><a href='index.php?amodul=zawodnicy&amp;akcja=edytuj&amp;id=".$z['z_id']."'>edytuj</a> - <a href='index.php?amodul=zawodnicy&amp;akcja=usun&amp;id=".$z['z_id']."' onclick=\"return confirm('Czy na pewno usunąć tego zawodnika?!');\">usuń</a></td>\n";
		
		echo "</tr>\n";
		$i++;
	}
	if ($i == 1) echo "<tr><td colspan='4'>brak zawodników</td></tr>\n";
	echo "</table>\n";

}
