REMOVE

<?php
require_once('../includes/config.php');
require_once('../includes/authenticate.php');
?>
<!DOCTYPE html>
<html>
<head>
<!--This is the page that is to load things inside of <head></head> section of the html sctructure-->
<?php
    require_once(dirname(__FILE__) . '/../includes/head-meta-tags.php');
    require_once(dirname(__FILE__) . '/../includes/head-bootstrap.php');
	//parts of head portion
    require_once(dirname(__FILE__) . '/../includes/head-ajax-spinner.php');
?>
</head>
<body>
<?php
$property_id = (int) $_GET['property_id'];
?>
<?php
$monthNames = Array(
    "January",
    "February",
    "March",
    "April",
    "May",
    "June",
    "July",
    "August",
    "September",
    "October",
    "November",
    "December"
);
?>
<?php
if (!isset($_REQUEST["month"]))
    $_REQUEST["month"] = date("n");
if (!isset($_REQUEST["year"]))
    $_REQUEST["year"] = date("Y");
?>
<?php
$cMonth = $_REQUEST["month"];
$cYear  = $_REQUEST["year"];
?>
<?php
// FOR Navigation ////
$prev_year  = $cYear;
$next_year  = $cYear;
$prev_month = $cMonth - 4;
$next_month = $cMonth + 4;
if ($prev_month == 0) {
    $prev_month = 12;
    $prev_year  = $cYear - 1;
} //$prev_month == 0
elseif ($prev_month == -1) {
    $prev_month = 11;
    $prev_year  = $cYear - 1;
} //$prev_month == -1
    elseif ($prev_month == -2) {
    $prev_month = 10;
    $prev_year  = $cYear - 1;
} //$prev_month == -2
    elseif ($prev_month == -3) {
    $prev_month = 9;
    $prev_year  = $cYear - 1;
} //$prev_month == -3
////////////////////////////
if ($next_month == 13) {
    $next_month = 1;
    $next_year  = $cYear + 1;
} //$next_month == 13
elseif ($next_month == 14) {
    $next_month = 2;
    $next_year  = $cYear + 1;
} //$next_month == 14
    elseif ($next_month == 15) {
    $next_month = 3;
    $next_year  = $cYear + 1;
} //$next_month == 15
    elseif ($next_month == 16) {
    $next_month = 4;
    $next_year  = $cYear + 1;
} //$next_month == 16
?>
<?php
    include "submit/properties-block-dates.php";
    include "../includes/alerts.php";
?>
<table align="center">
  <tr>
    <td><table width="100%" border="0" align="center">
        <tr>
          <td align="center" valign="top"><div align="left"><a href="<?php
			echo $_SERVER["PHP_SELF"] . "?month=" . $prev_month . "&year=" . $prev_year . "&property_id=" . $property_id;
			?>" >Previous</a></div></td>
          <td align="center" valign="top"><div align="right"><a href="<?php
			echo $_SERVER["PHP_SELF"] . "?month=" . $next_month . "&year=" . $next_year . "&property_id=" . $property_id;
			?>" >Next</a></div></td>
        </tr>
      </table>
      <form id="blockDatesForm" action="" method="post">
        <table border="0" align="center">
          <tr>
            <td align="center" valign="top"><table width="200" border="0" cellpadding="2" cellspacing="2">
                <tr align="center">
                  <td colspan="7" bgcolor="#999999" style="color:#FFFFFF"><strong>
                    <?php
					echo $monthNames[$cMonth - 1] . ' ' . $cYear;
					?>
                    </strong></td>
                </tr>
                <tr>
                  <td align="center" bgcolor="#999999" style="color:#FFFFFF"><strong>S</strong></td>
                  <td align="center" bgcolor="#999999" style="color:#FFFFFF"><strong>M</strong></td>
                  <td align="center" bgcolor="#999999" style="color:#FFFFFF"><strong>T</strong></td>
                  <td align="center" bgcolor="#999999" style="color:#FFFFFF"><strong>W</strong></td>
                  <td align="center" bgcolor="#999999" style="color:#FFFFFF"><strong>T</strong></td>
                  <td align="center" bgcolor="#999999" style="color:#FFFFFF"><strong>F</strong></td>
                  <td align="center" bgcolor="#999999" style="color:#FFFFFF"><strong>S</strong></td>
                </tr>
                <?php
				$timestamp = mktime(0, 0, 0, $cMonth, 1, $cYear);
				$maxday    = date("t", $timestamp);
				$thismonth = getdate($timestamp);
				$startday  = $thismonth['wday'];
				for ($i = 0; $i < ($maxday + $startday); $i++) {
					if (($i % 7) == 0) {
						echo "<tr>\n";
					} //($i % 7) == 0
					if ($i < $startday) {
						echo "<td></td>\n";
					} //$i < $startday
					else {
						$cDay       = ($i - $startday + 1);
						$cToday     = $cYear . "-" . $cMonth . "-" . $cDay;
						$cTodayId   = $cYear . "_" . $cMonth . "_" . $cDay;
						$resultcDay = mysql_query("SELECT * FROM " . CALENDAR . " WHERE date = '" . $cToday . "' AND property_id = '$property_id'");
						$numRows    = mysql_num_rows($resultcDay);
						if ($numRows == 0) {
							$dateColor = "#ffffff";
						} //$numRows == 0
						else {
							while ($rowcDay = mysql_fetch_array($resultcDay)) {
								$cDayStatus     = $rowcDay['status'];
								$reservation_id = $rowcDay['reservation_id'];
								$created_by     = $rowcDay['created_by'];
							} //$rowcDay = mysql_fetch_array($resultcDay)
							if ($cDayStatus == "booked") {
								$dateColor = "#ff0000";
							} //$cDayStatus == "booked"
							elseif ($cDayStatus == "pending") {
								$dateColor = "#ffff00";
							} //$cDayStatus == "pending"
								elseif ($cDayStatus == "blocked") {
								$dateColor = "#bbbbbb";
							} //$cDayStatus == "blocked"
						}
						echo '<td align="center" valign="middle">';
						echo $cDay;
						echo "<div style=\"background-color:$dateColor\">";
						echo "<input name=\"$cTodayId\" type=\"checkbox\" value=\"OWNER\"";
						if (!empty($cDayStatus))
							echo "checked=\"checked\" ";
						if (isset($reservation_id) AND $reservation_id <> '0')
							echo "disabled ";
						echo "/>";
						echo "</div>";
						echo "<input name=\"datestring[]\" type=\"hidden\" value=\"$cTodayId\" />";
						echo "</td>\n";
						unset($cDayStatus);
						unset($reservation_id);
						unset($dateColor);
						unset($created_by);
						unset($cToday);
						unset($cTodayId);
					}
					if (($i % 7) == 6) {
						echo "</tr>\n";
					} //($i % 7) == 6
				} //$i = 0; $i < ($maxday + $startday); $i++
				?>
              </table></td>
            <td align="center" valign="top"><?php
					$cMonth++;
					if ($cMonth == 13) {
						$cMonth = 1;
						$cYear  = $cYear + 1;
					} //$cMonth == 13
					elseif ($next_month == 14) {
						$cMonth = 2;
						$cYear  = $cYear + 1;
					} //$next_month == 14
						elseif ($next_month == 15) {
						$cMonth = 3;
						$cYear  = $cYear + 1;
					} //$next_month == 15
						elseif ($next_month == 16) {
						$cMonth = 4;
						$cYear  = $cYear + 1;
					} //$next_month == 16
					?>
              <table width="200" border="0" cellpadding="2" cellspacing="2">
                <tr align="center">
                  <td colspan="7" bgcolor="#999999" style="color:#FFFFFF"><strong>
                    <?php
					echo $monthNames[$cMonth - 1] . ' ' . $cYear;
					?>
                    </strong></td>
                </tr>
                <tr>
                  <td align="center" bgcolor="#999999" style="color:#FFFFFF"><strong>S</strong></td>
                  <td align="center" bgcolor="#999999" style="color:#FFFFFF"><strong>M</strong></td>
                  <td align="center" bgcolor="#999999" style="color:#FFFFFF"><strong>T</strong></td>
                  <td align="center" bgcolor="#999999" style="color:#FFFFFF"><strong>W</strong></td>
                  <td align="center" bgcolor="#999999" style="color:#FFFFFF"><strong>T</strong></td>
                  <td align="center" bgcolor="#999999" style="color:#FFFFFF"><strong>F</strong></td>
                  <td align="center" bgcolor="#999999" style="color:#FFFFFF"><strong>S</strong></td>
                </tr>
                <?php
					$timestamp = mktime(0, 0, 0, $cMonth, 1, $cYear);
					$maxday    = date("t", $timestamp);
					$thismonth = getdate($timestamp);
					$startday  = $thismonth['wday'];
					for ($i = 0; $i < ($maxday + $startday); $i++) {
						if (($i % 7) == 0) {
							echo "<tr>\n";
						} //($i % 7) == 0
						if ($i < $startday) {
							echo "<td></td>\n";
						} //$i < $startday
						else {
							$cDay       = ($i - $startday + 1);
							$cToday     = $cYear . "-" . $cMonth . "-" . $cDay;
							$cTodayId   = $cYear . "_" . $cMonth . "_" . $cDay;
							$resultcDay = mysql_query("SELECT * FROM " . CALENDAR . " WHERE date = '" . $cToday . "' AND property_id = '$property_id'");
							$numRows    = mysql_num_rows($resultcDay);
							if ($numRows == 0) {
								$dateColor = "#ffffff";
							} //$numRows == 0
							else {
								while ($rowcDay = mysql_fetch_array($resultcDay)) {
									$cDayStatus     = $rowcDay['status'];
									$reservation_id = $rowcDay['reservation_id'];
									$created_by     = $rowcDay['created_by'];
								} //$rowcDay = mysql_fetch_array($resultcDay)
								if ($cDayStatus == "booked") {
									$dateColor = "#ff0000";
								} //$cDayStatus == "booked"
								elseif ($cDayStatus == "pending") {
									$dateColor = "#ffff00";
								} //$cDayStatus == "pending"
									elseif ($cDayStatus == "blocked") {
									$dateColor = "#bbbbbb";
								} //$cDayStatus == "blocked"
							}
							echo '<td align="center" valign="middle">';
							echo $cDay;
							echo "<div style=\"background-color:$dateColor\">";
							echo "<input name=\"$cTodayId\" type=\"checkbox\" value=\"OWNER\"";
							if (!empty($cDayStatus))
								echo "checked=\"checked\" ";
							if (isset($reservation_id) AND $reservation_id <> '0')
								echo "disabled ";
							echo "/>";
							echo "</div>";
							echo "<input name=\"datestring[]\" type=\"hidden\" value=\"$cTodayId\" />";
							echo "</td>\n";
							unset($cDayStatus);
							unset($reservation_id);
							unset($dateColor);
							unset($created_by);
							unset($cToday);
							unset($cTodayId);
						}
						if (($i % 7) == 6) {
							echo "</tr>\n";
						} //($i % 7) == 6
					} //$i = 0; $i < ($maxday + $startday); $i++
					?>
              </table></td>
          </tr>
          <tr>
            <td align="center" valign="top"><?php
			$cMonth++;
			if ($cMonth == 13) {
				$cMonth = 1;
				$cYear  = $cYear + 1;
			} //$cMonth == 13
			elseif ($next_month == 14) {
				$cMonth = 2;
				$cYear  = $cYear + 1;
			} //$next_month == 14
				elseif ($next_month == 15) {
				$cMonth = 3;
				$cYear  = $cYear + 1;
			} //$next_month == 15
				elseif ($next_month == 16) {
				$cMonth = 4;
				$cYear  = $cYear + 1;
			} //$next_month == 16
			?>
              <table width="200" border="0" cellpadding="2" cellspacing="2">
                <tr align="center">
                  <td colspan="7" bgcolor="#999999" style="color:#FFFFFF"><strong>
                    <?php
					echo $monthNames[$cMonth - 1] . ' ' . $cYear;
					?>
                    </strong></td>
                </tr>
                <tr>
                  <td align="center" bgcolor="#999999" style="color:#FFFFFF"><strong>S</strong></td>
                  <td align="center" bgcolor="#999999" style="color:#FFFFFF"><strong>M</strong></td>
                  <td align="center" bgcolor="#999999" style="color:#FFFFFF"><strong>T</strong></td>
                  <td align="center" bgcolor="#999999" style="color:#FFFFFF"><strong>W</strong></td>
                  <td align="center" bgcolor="#999999" style="color:#FFFFFF"><strong>T</strong></td>
                  <td align="center" bgcolor="#999999" style="color:#FFFFFF"><strong>F</strong></td>
                  <td align="center" bgcolor="#999999" style="color:#FFFFFF"><strong>S</strong></td>
                </tr>
                <?php
				$timestamp = mktime(0, 0, 0, $cMonth, 1, $cYear);
				$maxday    = date("t", $timestamp);
				$thismonth = getdate($timestamp);
				$startday  = $thismonth['wday'];
				for ($i = 0; $i < ($maxday + $startday); $i++) {
					if (($i % 7) == 0) {
						echo "<tr>\n";
					} //($i % 7) == 0
					if ($i < $startday) {
						echo "<td></td>\n";
					} //$i < $startday
					else {
						$cDay       = ($i - $startday + 1);
						$cToday     = $cYear . "-" . $cMonth . "-" . $cDay;
						$cTodayId   = $cYear . "_" . $cMonth . "_" . $cDay;
						$resultcDay = mysql_query("SELECT * FROM " . CALENDAR . " WHERE date = '" . $cToday . "' AND property_id = '$property_id'");
						$numRows    = mysql_num_rows($resultcDay);
						if ($numRows == 0) {
							$dateColor = "#ffffff";
						} //$numRows == 0
						else {
							while ($rowcDay = mysql_fetch_array($resultcDay)) {
								$cDayStatus     = $rowcDay['status'];
								$reservation_id = $rowcDay['reservation_id'];
								$created_by     = $rowcDay['created_by'];
							} //$rowcDay = mysql_fetch_array($resultcDay)
							if ($cDayStatus == "booked") {
								$dateColor = "#ff0000";
							} //$cDayStatus == "booked"
							elseif ($cDayStatus == "pending") {
								$dateColor = "#ffff00";
							} //$cDayStatus == "pending"
								elseif ($cDayStatus == "blocked") {
								$dateColor = "#bbbbbb";
							} //$cDayStatus == "blocked"
						}
						echo '<td align="center" valign="middle">';
						echo $cDay;
						echo "<div style=\"background-color:$dateColor\">";
						echo "<input name=\"$cTodayId\" type=\"checkbox\" value=\"OWNER\"";
						if (!empty($cDayStatus))
							echo "checked=\"checked\" ";
						if (isset($reservation_id) AND $reservation_id <> '0')
							echo "disabled ";
						echo "/>";
						echo "</div>";
						echo "<input name=\"datestring[]\" type=\"hidden\" value=\"$cTodayId\" />";
						echo "</td>\n";
						unset($cDayStatus);
						unset($reservation_id);
						unset($dateColor);
						unset($created_by);
						unset($cToday);
						unset($cTodayId);
					}
					if (($i % 7) == 6) {
						echo "</tr>\n";
					} //($i % 7) == 6
				} //$i = 0; $i < ($maxday + $startday); $i++
				?>
              </table></td>
            <td align="center" valign="top"><?php
			$cMonth++;
			if ($cMonth == 13) {
				$cMonth = 1;
				$cYear  = $cYear + 1;
			} //$cMonth == 13
			elseif ($next_month == 14) {
				$cMonth = 2;
				$cYear  = $cYear + 1;
			} //$next_month == 14
				elseif ($next_month == 15) {
				$cMonth = 3;
				$cYear  = $cYear + 1;
			} //$next_month == 15
				elseif ($next_month == 16) {
				$cMonth = 4;
				$cYear  = $cYear + 1;
			} //$next_month == 16
			?>
              <table width="200" border="0" cellpadding="2" cellspacing="2">
                <tr align="center">
                  <td colspan="7" bgcolor="#999999" style="color:#FFFFFF"><strong>
                    <?php
					echo $monthNames[$cMonth - 1] . ' ' . $cYear;
					?>
                    </strong></td>
                </tr>
                <tr>
                  <td align="center" bgcolor="#999999" style="color:#FFFFFF"><strong>S</strong></td>
                  <td align="center" bgcolor="#999999" style="color:#FFFFFF"><strong>M</strong></td>
                  <td align="center" bgcolor="#999999" style="color:#FFFFFF"><strong>T</strong></td>
                  <td align="center" bgcolor="#999999" style="color:#FFFFFF"><strong>W</strong></td>
                  <td align="center" bgcolor="#999999" style="color:#FFFFFF"><strong>T</strong></td>
                  <td align="center" bgcolor="#999999" style="color:#FFFFFF"><strong>F</strong></td>
                  <td align="center" bgcolor="#999999" style="color:#FFFFFF"><strong>S</strong></td>
                </tr>
                <?php
				$timestamp = mktime(0, 0, 0, $cMonth, 1, $cYear);
				$maxday    = date("t", $timestamp);
				$thismonth = getdate($timestamp);
				$startday  = $thismonth['wday'];
				for ($i = 0; $i < ($maxday + $startday); $i++) {
					if (($i % 7) == 0) {
						echo "<tr>\n";
					} //($i % 7) == 0
					if ($i < $startday) {
						echo "<td></td>\n";
					} //$i < $startday
					else {
						$cDay       = ($i - $startday + 1);
						$cToday     = $cYear . "-" . $cMonth . "-" . $cDay;
						$cTodayId   = $cYear . "_" . $cMonth . "_" . $cDay;
						$resultcDay = mysql_query("SELECT * FROM " . CALENDAR . " WHERE date = '" . $cToday . "' AND property_id = '$property_id'");
						$numRows    = mysql_num_rows($resultcDay);
						if ($numRows == 0) {
							$dateColor = "#ffffff";
						} //$numRows == 0
						else {
							while ($rowcDay = mysql_fetch_array($resultcDay)) {
								$cDayStatus     = $rowcDay['status'];
								$reservation_id = $rowcDay['reservation_id'];
								$created_by     = $rowcDay['created_by'];
							} //$rowcDay = mysql_fetch_array($resultcDay)
							if ($cDayStatus == "booked") {
								$dateColor = "#ff0000";
							} //$cDayStatus == "booked"
							elseif ($cDayStatus == "pending") {
								$dateColor = "#ffff00";
							} //$cDayStatus == "pending"
								elseif ($cDayStatus == "blocked") {
								$dateColor = "#bbbbbb";
							} //$cDayStatus == "blocked"
						}
						echo '<td align="center" valign="middle">';
						echo $cDay;
						echo "<div style=\"background-color:$dateColor\">";
						echo "<input name=\"$cTodayId\" type=\"checkbox\" value=\"OWNER\"";
						if (!empty($cDayStatus))
							echo "checked=\"checked\" ";
						if (isset($reservation_id) AND $reservation_id <> '0')
							echo "disabled ";
						echo "/>";
						echo "</div>";
						echo "<input name=\"datestring[]\" type=\"hidden\" value=\"$cTodayId\" />";
						echo "</td>\n";
						unset($cDayStatus);
						unset($reservation_id);
						unset($dateColor);
						unset($created_by);
						unset($cToday);
						unset($cTodayId);
					}
					if (($i % 7) == 6) {
						echo "</tr>\n";
					} //($i % 7) == 6
				} //$i = 0; $i < ($maxday + $startday); $i++
				?>
              </table></td>
          </tr>
        </table>
      </form></td>
  </tr>
  <tr>
    <td><table border="0" align="center">
        <tr>
          <td width="20" bgcolor="#ff0000">&nbsp;</td>
          <td>Booked for Guest</td>
          <td width="20" bgcolor="#ffffff">&nbsp;</td>
          <td width="20" bgcolor="#bbbbbb">&nbsp;</td>
          <td>Blocked by Admin</td>
        </tr>
      </table></td>
  </tr>
</table>
</body>
</html>
