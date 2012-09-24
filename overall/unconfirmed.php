<?php
include_once("../pageheader.php");
include_once("../teamMatch.php");

if (isset($_GET['team']))
	$team=mysql_escape_string($_GET['team']);
else
	$team=0;

if (isset($_SESSION['login']))
{
	if ($_SESSION['login'] == "1c7943b67b2c1a6f9b1468ee9e830509")
	{

?>

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<link href="../styles.css" rel="stylesheet" type="text/css" />
<link href="tablesorter/themes/blue/style.css" rel="stylesheet" type="text/css" />
<link href='http://fonts.googleapis.com/css?family=Kameron:700,400' rel='stylesheet' type='text/css'>
<script src="../jquery-1.7.2.min.js" type="text/javascript"></script>
<script src="../jquery.maskedinput-1.3.js" type="text/javascript"></script>
<script src="../jquery-validation-1.9.0/jquery.validate.min.js" type="text/javascript"></script>
<script src="../livevalidation_stand	alone.compressed.js" type="text/javascript"></script>
<script type="text/javascript" src="tablesorter/jquery.tablesorter.js"></script> 

<head>
<title>Captain Application</title>
<script type="text/javascript">

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-34432499-1']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

</script>
</head>
<body>
<div class="overall_container">

    
<h1 style="text-align:left; margin-left:20px;"><?php echo getTeam($team); ?> </h1>


<table id="myTable" class="tablesorter"> 
<thead> 
<tr> 
    <th>UFID</th> 
    <th>Last Name</th>
    <th>First Name</th> 
    <th>Interview Time</th> 
    <th>Returning</th>
    <th>First Choice</th> 
    <th>Second Choice</th>
    <th>Third Choice</th>
    <th>GPA</th>
    <th>Major</th>
    <th>UFL Email</th>
    <th>Phone Number</th>
    <th>Started</th>
    <th>Last Edited</th>    
</tr> 
</thead> 
<tbody> 


<?php

if ($team)
	$sql0 = "SELECT * From Applicants WHERE (teama = $team or teamb = $team)";
else
	$sql0 = "SELECT * From Applicants";
$sql0 = mysql_query($sql0);

$i=0;
while ($applicant = mysql_fetch_assoc($sql0))
{
	$i++;
	if ($team == $applicant['teama'])
	{
		$interviewd = $applicant['interview1d'];
		$interviewt = $applicant['interview1t'];
	}
	else if ($team == $applicant['teamb'])
	{
		$interviewd = $applicant['interview2d'];
		$interviewt = $applicant['interview2t'];
	
	}
	else
	{
		$interviewd = 0;
		$interviewt = 0;	
	}

	if ($team)
	{
		if (($team == $applicant['captain1']) || ($team == $applicant['captain2']))
		{
			$returning = "Yes";
		}
		else
		{
			$returning = "No";
		}
	}
	else if ($applicant['captain1'] || $applicant['captain2'])
	{
		$returning = "Yes";
					
	}
	else
	{
		$returning = "No";
	}


	echo '<tr>';
	echo '<td> <a href="applicant.php?ufid=' . $applicant['ufid'] . '&team='.$team.'">' . $applicant['ufid'] . '</a></td>';
	echo '<td>' . $applicant['last'] . '</td>';
	echo '<td>' . $applicant['first'] . '</td>';
	echo '<td>' . fixInterview($interviewd,$interviewt)  . '</td>';
	echo '<td>' . $returning . '</td>';	
	echo '<td><a href="unconfirmed.php?team='.$applicant['teama'].'">'. getTeam($applicant['teama']) . '</a></td>';
	echo '<td><a href="unconfirmed.php?team='.$applicant['teamb'].'">'. getTeam($applicant['teamb']) . '</a></td>';
	echo '<td><a href="unconfirmed.php?team='.$applicant['teamc'].'">'. getTeam($applicant['teamc']) . '</a></td>';	
	echo '<td>' . $applicant['gpa'] . '</td>';
	echo '<td>' . $applicant['major'] . '</td>';
	echo '<td><a href="mailto:' . $applicant['uflemail'] . '">' . $applicant['uflemail'] .'</a></td>';
	echo '<td>' . $applicant['phone'] . '</td>';
	echo '<td>' . $applicant['started'] . '</td>';
	echo '<td>' . $applicant['ended'] . '</td></tr>';		

//	print_r($sql1);
}

?>

</tbody> 
</table> 
<?php echo '<p style="margin-left:10px;">'. $i .' rows</p>'; ?>
<script type="text/javascript">
$(document).ready(function() 
    { 
        $("#myTable").tablesorter({
	        
	        sortList: [[13,0]]
        });
    } 
); 
    
</script>



</div>
</div>
</div>
<?php 	}
	else
	{
		$_SESSION['redirect']='unconfirmed.php?team='.$team;
		header("Location:index.php");
	}
}
else
{
	$_SESSION['redirect']='unconfirmed.php?team='.$team;
	header("Location:index.php");
} ?>