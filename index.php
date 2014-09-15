<?php
$result = file_get_contents("https://api.tokyometroapp.jp/api/v2/datapoints?rdf:type=odpt:Station&acl:consumerKey=2b6341efbf502781c1be49bf3228cb02918742950472cc8302dc9fca452fe3aa");
$informations = json_decode($result);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Index</title>
</head>
<body>

<h2>Station 1</h2>
<form method="post" action="sample.php">

<p>
<select name="station_1">
<?php foreach($informations as $information){ ?>
<?php $info = get_object_vars($information); ?>

<option value=<?php echo $info["@id"]; ?>><?php echo $info["dc:title"];?></option>
<?php } ?>

</select>
</p>

<h2>Station 2</h2>
<select name="station_2">
<?php foreach($informations as $information){ ?>
<?php $info = get_object_vars($information); ?>

<option value=<?php echo $info["owl:sameAs"]; ?>><?php echo $info["dc:title"];?></option>
<?php } ?>

</select>
</p>

<p><input type="submit" value="送信する"></p>

</form>
</body>
</html>
