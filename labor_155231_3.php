<?php
$nr_indeksu = '155231';
$nr_grupy = '3';
echo 'Dominik Lewandowski ' . $nr_indeksu . ' grupa ' . $nr_grupy . '<br /><br />';

echo 'Zastosowanie metody include():<br />';
include 'vars.php';
echo 'Kupilem ' . $color . ' ' . $item . '<br /> <br />';

echo 'Zastosowanie metody require_once():<br /><br />';

$warunek = 2;
?>
<?php
echo '<h2>Warunki if, else, elseif:</h2>';

if ($warunek == '1') :

    echo '<h3>Kod html jesli warunek jest rowny 1</h3>';

elseif ($warunek == '2') :

    echo '<h3>Kod html jesli warunek jest rowny 2</h3>';
else :

    echo '<h3>Kod html w kazdym innym przypadku';
endif
?>


<?php
echo '<h2>Instrukcja warunkowa switch:</h2>';
switch ($warunek) {
    case 1:
        echo '<h3>Kod w przypadku 1 (switch)<br />';
        break;
    case 2:
        echo 'Kod w przypadku 2 (switch)</h3>';
        break;
    default:
        echo 'Kod jesli zaden warunek nie jest spelniony (switch)</h3>';
}
?>

<?php
echo '<h2>Petla for od 1 do 10:</h2>';
$i = 1;
for ($i = 1; $i <= 10; $i++) {
    echo $i . ' ';
}
?>

<?php
echo '<h2>Petla while od 10 do 1:</h2>';
$j = 10;
while ($j > 0) {
    echo $j-- . ' ';
}
?>
<h2>Uzycie $_GET</h2>
<form method="get">
    <label for="name">Podaj swoje imie: </label>
    <input type="text" name="name">
    <button type="submit">Wyslij</button>
</form>
<?php
echo 'Hello ' . htmlspecialchars($_GET["name"]) . '!';
?>

<h2>Uzycie $_POST</h2>
<form method="post">
    <label for="name">Podaj swoje imie: </label>
    <input type="text" name="name">
    <button type="submit">Wyslij</button>
</form>
<?php
echo 'Hello ' . htmlspecialchars($_POST["name"]) . '!';
?>