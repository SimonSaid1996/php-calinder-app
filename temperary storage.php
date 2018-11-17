<?php
/
require 'SoftInfo.php';

$connection = mysqli_connect($dbserver,$dbuser,$dbpass,$dbdatabase);

if($connection === false) {
    // Handle error - notify administrator, log to a file, show an error screen, etc.
	echo "connection error";
	echo mysqli_error($connection);
}
	//$lengths = mysql_fetch_lengths($result);	

/*$userEmail=$_GET['emialN'];// get user email input
*/	
$activityStartDateArray=array();
$activityEndDateArray=array();
//to storage data in the database and check in the future
	$resultASD = mysqli_query($connection, "SELECT startDate FROM activity ");//the activity startdate
	if($resultASD === false) {
			echo 'no startDate found.';
			//generic error message
			echo mysqli_error($connection);
		} 
	else{
		$resultASDate = mysqli_query($connection, "SELECT startDate FROM activity");

				while ($activitySDExist = mysqli_fetch_assoc($resultASDate)) {
					$activityStartD=$activitySDExist['startDate'];
					array_push($activityStartDateArray,$activityStartD);//insert startdate
				}
		}

	$resultAED = mysqli_query($connection, "SELECT endDate FROM activity ");
	if($resultAED === false) {
			echo 'no endDate found.';
			//generic error message
			echo mysqli_error($connection);
		} 
	else{
		$resultAEDate = mysqli_query($connection, "SELECT endDate FROM activity");//another table

				while ($activityEDExist = mysqli_fetch_assoc($resultAEDate)) {
					$activityEndD=$activityEDExist['endDate'];
					array_push($activityEndDateArray,$activityEndD);//insert enddate
				}
		}
	
//,$activityEndDateArray=array()
/* draws a calendar */
function draw_calendar($month,$year,$activityStartDateArray = array()){

	/* draw table */
	$calendar = '<table cellpadding="0" cellspacing="0" class="calendar">';

	/* table headings */
	$headings = array('Sunday','Monday','Tuesday','Wednesday','Thursday','Friday','Saturday');
	$calendar.= '<tr class="calendar-row"><td class="calendar-day-head">'.implode('</td><td class="calendar-day-head">',$headings).'</td></tr>';

	/* days and weeks vars now ... */
	$running_day = date('w',mktime(0,0,0,$month,1,$year));
	$days_in_month = date('t',mktime(0,0,0,$month,1,$year));
	$days_in_this_week = 1;
	$day_counter = 0;
	$dates_array = array();

	/* row for week one */
	$calendar.= '<tr class="calendar-row">';

	/* print "blank" days until the first of the current week */
	for($x = 0; $x < $running_day; $x++):
		$calendar.= '<td class="calendar-day-np">&nbsp;</td>';
		$days_in_this_week++;
	endfor;

	/* keep going with days.... */
	for($list_day = 1; $list_day <= $days_in_month; $list_day++):
		$calendar.= '<td class="calendar-day"><div style="position:relative;height:100px;">';
			/* add in the day number */
			$calendar.= '<div class="day-number">'.$list_day.'</div>';
			
			//eventdate=startdate and enddate, depends which we talks about 

			$startDate = $year.'-'.$month.'-'.$list_day;
			//$endDate = $year.'-'.$month.'-'.$list_day;
			echo "<br>the start date is".$startDate;
			//something is wrong wit hteh startDate, the origin code has a while loop in the beginning, think why 
			
			if(isset($activityStartDateArray[$startDate])) {
				foreach($activityStartDateArray[$startDate] as $activity) {
					$calendar.= '<div class="activity">'.$activity['activityName'].'</div>';
				}
			}
		
			else {
				$calendar.= str_repeat('<p>&nbsp;</p>',2);
			}
		$calendar.= '</div></td>';
		if($running_day == 6):
			$calendar.= '</tr>';
			if(($day_counter+1) != $days_in_month):
				$calendar.= '<tr class="calendar-row">';
			endif;
			$running_day = -1;
			$days_in_this_week = 0;
		endif;
		$days_in_this_week++; $running_day++; $day_counter++;
	endfor;
	
	
	/* finish the rest of the days in the week */
	if($days_in_this_week < 8):
		for($x = 1; $x <= (8 - $days_in_this_week); $x++):
			$calendar.= '<td class="calendar-day-np">&nbsp;</td>';
		endfor;
	endif;

	/* final row */
	$calendar.= '</tr>';
	

	/* end the table */
	$calendar.= '</table>';

	/** DEBUG **/
	$calendar = str_replace('</td>','</td>'."\n",$calendar);
	$calendar = str_replace('</tr>','</tr>'."\n",$calendar);
	
	/* all done, return result */
	return $calendar;
}

function random_number() {
	srand(time());
	return (rand() % 7);
}

/* date settings */


$month = (int) ($_GET['month'] ? $_GET['month'] : date('m'));
$year = (int)  ($_GET['year'] ? $_GET['year'] : date('Y'));
//issues here
//and didn't draw any events.












/* select month control */
$select_month_control = '<select name="month" id="month">';
for($x = 1; $x <= 12; $x++) {
	$select_month_control.= '<option value="'.$x.'"'.($x != $month ? '' : ' selected="selected"').'>'.date('F',mktime(0,0,0,$x,1,$year)).'</option>';
}
$select_month_control.= '</select>';

/* select year control */
$year_range = 7;
$select_year_control = '<select name="year" id="year">';
for($x = ($year-floor($year_range/2)); $x <= ($year+floor($year_range/2)); $x++) {
	$select_year_control.= '<option value="'.$x.'"'.($x != $year ? '' : ' selected="selected"').'>'.$x.'</option>';
}
$select_year_control.= '</select>';

/* "next month" control */
$next_month_link = '<a href="?month='.($month != 12 ? $month + 1 : 1).'&year='.($month != 12 ? $year : $year + 1).'" class="control">Next Month &gt;&gt;</a>';

/* "previous month" control */
$previous_month_link = '<a href="?month='.($month != 1 ? $month - 1 : 12).'&year='.($month != 1 ? $year : $year - 1).'" class="control">&lt;&lt; 	Previous Month</a>';


/* bringing the controls together */
$controls = '<form method="get">'.$select_month_control.$select_year_control.'&nbsp;<input type="submit" name="submit" value="Go" />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$previous_month_link.'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$next_month_link.' </form>';

/* get all activity for the given month */
//$activity = array();


echo '<h2 style="float:left; padding-right:30px;">'.date('F',mktime(0,0,0,$month,1,$year)).' '.$year.'</h2>';
echo '<div style="float:left;">'.$controls.'</div>';
echo '<div style="clear:both;"></div>';
echo draw_calendar($month,$year,$activityStartDateArray);//,$activityEndDateArray
echo '<br /><br />';


?>