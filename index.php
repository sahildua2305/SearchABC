<?php
$connection = mysqli_connect("localhost","root","","wordpress");

?>

<!DOCTYPE html>
<html>
<head>
<title>Search ABC</title>
</head>
<body>

<form action="" method="GET">
<input type="text" name="query" placeholder="Search" required/>
<input type="submit" name="search" value="Search"/>
</form>

<?php

if(isset($_GET['search']) && !empty($_GET['query']))
{
	//..............manupulating the entered query
	$query = strip_tags($_GET['query']);
	$len = strlen($query);
	/*$query = str_replace(" ", "", $query);
	$len = strlen($query);*/
	$piece = explode(" ",$query);
	$query ="";
	foreach($piece as $a)
	{
		$query .= $a;
	}
	$len = strlen($query);

	$result = mysqli_query($connection,"SELECT * from wp_posts WHERE post_title like '$query[0]%'");

	if(!mysqli_num_rows($result))
	{
		echo "Nothing found! ";
	}
	while($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
	{
		$pieces = explode(" ",$row['post_title']);
		$acronym ="";
	
		foreach($pieces as $p)
		{
			$acronym .= $p[0];
		}
		$something = '0';
		for($i=1;$i<$len;$i++)
		{
			if($len > strlen($acronym))
			{
				$something = '1';
				break;
			}
			if($query[$i] != lcfirst($acronym[$i]) && $query[$i] != ucfirst($acronym[$i]))
			{
				$something = '1';
				break;
			}
		}
		if($something == '0')
		{
			echo "<a href='".$row['guid']."'>".$row['post_title']."</a><br>";
		}
	} //while loop
} //If statement
?>
