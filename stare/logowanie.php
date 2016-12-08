<?php

echo "<h1>Logowanie</h1>\n";

if (isset($_POST['zaloguj'])) {
	if ($_POST['pass'] == $hasloAdmin) {
		$_SESSION['admin'] = md5($hasloAdmin);
		header("Location: index.php");
	} else {
		echo "<div class='error'>Złe hasło!</div>\n";
	}
}

echo "<form action='index.php?modul=logowanie' method='post'>\n";

echo "<p>
Podaj hasło dostępu: <input name='pass' type='password' /><br />
<input type='submit' name='zaloguj' value='zaloguj' />
</p>\n";

echo "</form>\n";
