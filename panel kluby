<?php

if (isset($_GET['akcja']) && $_GET['akcja'] == "dodaj") {
	echo "<h1>Dodanie klubu</h1>\n";
	
		if (isset($_POST['dodaj'])) {
			if (!empty($_POST['k_nazwa']) && !empty($_POST['k_panstwo'])) {
				$insert = mysql_query("INSERT INTO kluby (k_nazwa, k_panstwo) VALUES ('".$_POST['k_nazwa']."', '".$_POST['k_panstwo']."')");
				echo "<div class='success'>Klub został dodany! Teraz możesz dodać następny!</div>\n";
			} else {
				echo "<div class='error'>Nazwa oraz państwo są obowiązkowe!</div>\n";
			}
		}
		if (!isset($_POST['k_nazwa'])) $_POST['k_nazwa'] = "";
		if (!isset($_POST['k_panstwo'])) $_POST['k_panstwo'] = "";
		echo "<form action='index.php?amodul=kluby&amp;akcja=dodaj' method='post'>\n";
		echo "<table>";
		echo "<tr><td>Nazwa:</td><td><input type='text' name='k_nazwa' maxlength='100' value='".$_POST['k_nazwa']."' /></td></tr>\n";
		echo "<tr><td>Państwo:</td><td><select name='k_panstwo'>";
		$panstwa = mysql_query("SELECT * FROM państwa ORDER by p_nazwa");
		while ($p = mysql_fetch_array($panstwa)) {
			if ($_POST['k_panstwo'] == $p['p_id']) {
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
	$klub = mysql_fetch_array(mysql_query("SELECT * FROM kluby WHERE k_id = '".$id."' LIMIT 1"));
	if ($klub) {
		echo "<h1>Edycja klubu</h1>\n";
		
		if (isset($_POST['zapisz']) && !empty($_POST['k_nazwa']) && !empty($_POST['k_panstwo'])) {
			$zapisz = mysql_query("UPDATE kluby SET k_nazwa = '".$_POST['k_nazwa']."', k_panstwo = '".$_POST['k_panstwo']."' WHERE k_id = '".$id."' LIMIT 1");
			echo "<div class='success'>Zapisano zmiany!</div>\n";
			$klub = mysql_fetch_array(mysql_query("SELECT * FROM kluby WHERE k_id = '".$id."' LIMIT 1"));
		}
		
		echo "<form action='index.php?amodul=kluby&amp;akcja=edytuj&amp;id=".$id."' method='post'>\n";
		echo "<table>";
		echo "<tr><td>Nazwa:</td><td><input type='text' name='k_nazwa' maxlength='100' value='".$klub['k_nazwa']."' /></td></tr>\n";
		echo "<tr><td>Państwo:</td><td><select name='k_panstwo'>";
		$panstwa = mysql_query("SELECT * FROM państwa ORDER by p_nazwa");
		while ($p = mysql_fetch_array($panstwa)) {
			if ($klub['k_panstwo'] == $p['p_id']) {
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
	echo "<h1>Zarządzanie klubami</h1>\n";
	
	if (isset($_GET['akcja']) && $_GET['akcja'] == "usun" && isset($_GET['id'])) {
		$id = $_GET['id'];
		$delete = mysql_query("DELETE FROM kluby WHERE k_id = '".$id."' LIMIT 1");
		if ($delete) {
			echo "<div class='success'>Wybrany klub został usunięty!</div>\n";
		} else {
			echo "<div class='error'>".mysql_error()."</div>\n";
		}
	}
	
	echo "<div class='center'><a href='index.php?amodul=kluby&amp;akcja=dodaj'>dodaj klub</a></div>\n";
	
	$kluby = mysql_query("SELECT * FROM kluby k JOIN państwa p ON k.k_panstwo=p.p_id ORDER by k_nazwa");

	echo "<table>\n";
	echo "<tr class='first'><td>Nazwa</td><td>Państwo</td><td>Opcje</td></tr>\n";
	$i = 1;
	while ($k = mysql_fetch_array($kluby)) {
		echo "<tr>\n";
		
		echo "<td>".$k['k_nazwa']."</td>\n";
		
		echo "<td>".$k['p_nazwa']."</td>\n";
		
		echo "<td><a href='index.php?amodul=kluby&amp;akcja=edytuj&amp;id=".$k['k_id']."'>edytuj</a> - <a href='index.php?amodul=kluby&amp;akcja=usun&amp;id=".$k['k_id']."' onclick=\"return confirm('Czy na pewno usunąć ten klub?!');\">usuń</a></td>\n";
		
		echo "</tr>\n";
		$i++;
	}
	if ($i == 1) echo "<tr><td colspan='3'>brak klubów</td></tr>\n";
	echo "</table>\n";

}
