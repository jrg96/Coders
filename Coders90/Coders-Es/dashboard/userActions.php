<!--                Copyright (c) 2014 
José Fernando Flores Santamaría <fer.santamaria@programmer.net>
#
# This program is free software: you can redistribute it and/or modify
# it under the terms of the GNU General Public License as published by
# the Free Software Foundation, either version 3 of the License, or
# (at your option) any later version.
#
# This program is distributed in the hope that it will be useful,
# but WITHOUT ANY WARRANTY; without even the implied warranty of
# MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
# GNU General Public License for more details.
#
# You should have received a copy of the GNU General Public License
# along with this program. If not, see <http://www.gnu.org/licenses/>.
-->
<?php
	session_save_path("../sessions/");
	session_start();
	$action=$_POST['action'];
	date_default_timezone_set("America/El_Salvador");
	include("../BDD.php");

	switch ($action) {
		
		case "postComment":
			$cdate=date("Y-m-d");
			$chour=date("H:i:s");

			$content=$_POST['contents'];
			$postIdf=$_POST['postidf'];


			$query="INSERT INTO postcomments values('','".$_SESSION['UserID']."','".$content."','1','".$cdate."','".$chour."','".$postIdf."')";
			$sql=mysql_query($query,$dbconn);

			//Notificaciones de comentarios
			$mypost=strpos($postIdf, $_SESSION['UserID']);

			if ($mypost===false) {
				$user=substr($postIdf, 0,20);
				$ndate=date("Y-m-d");
				$ntime=date("H:i:s");
				$query="INSERT INTO notifications values('','".$user."','0','".$ndate."','".$ntime."','".$_SESSION['UserID']."','1','".$postIdf."')";
				$sql=mysql_query($query,$dbconn);
			}
			

			break;

		case "delComment":
			$idf=$_POST['idf'];

			$query="UPDATE postcomments SET View='0' WHERE CommentID='".$idf."' LIMIT 1";
			$sql=mysql_query($query,$dbconn);
			break;

		case "delPost":
			$idf=$_POST['idf'];
			
			$query="UPDATE post SET View='0' WHERE PostID='".$idf."' LIMIT 1";
			$sql=mysql_query($query,$dbconn);
			break;
		
	}

?>