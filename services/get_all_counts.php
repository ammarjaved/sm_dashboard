<?php
session_start();
include 'connection.php';
$output = array();

$week = $_GET['week'];
$month = $_GET['month'];
$year = $_GET['year'];


if ($week == ''){
    $year_sql = "select MAX(year) from tbl_survey_details";
    $year_q= pg_query($year_sql);
    $year_f =pg_fetch_all($year_q);
    $year = $year_f[0]['max'];
     
    $month_sql = "select MAX(month) from tbl_survey_details where year = '$year'";
    $month_q= pg_query($month_sql);
    $month_f = pg_fetch_all($month_q);
    $month = $month_f[0]['max'];

    $week_sql= "select MAX(week_no) from tbl_survey_details where month = '$month'";
    $week_q = pg_query($week_sql);
    $week_f = pg_fetch_all($week_q);
    $week = $week_f[0]['max'];
    

}



$sql1="select count(*) from tbl_survey_details where 
week_no='$week' and month='$month' and year ='$year'";
$sql2="select count(*) from tbl_survey_details where installed_status='Unsurveyed' and 
week_no='$week' and month='$month' and year ='$year'";
$sql3="select count(*) from tbl_survey_details where installed_status='Installed' and 
week_no='$week' and month='$month' and year ='$year'";
$sql4="select count(*) from tbl_survey_details where installed_status='TRAS'and 
week_no='$week' and month='$month' and year ='$year'";
$sql5="select count(*) from tbl_survey_details where installed_status ='0'and 
week_no='$week' and month='$month' and year ='$year'";
$sql6="select count(*) from tbl_survey_details where week_no =(select  max(week_no) from tbl_survey_details) and installed_status<>''";

//echo $sql1."<br/>";
$query1=pg_query($sql1);
$query2=pg_query($sql2);
$query3=pg_query($sql3);
$query4=pg_query($sql4);
$query5=pg_query($sql5);
$query6=pg_query($sql6);


if($query1)
{
    $output['total'] = pg_fetch_all($query1);
}
if($query2)
{
    $output['not_surveyed'] = pg_fetch_all($query2);
}
if($query3)
{
    $output['installed'] = pg_fetch_all($query3);
}
if($query4)
{
    $output['tras'] = pg_fetch_all($query4);
}
if($query5)
{
    $output['remaining'] = pg_fetch_all($query5);
}
if($query6)
{
    $output['week'] = pg_fetch_all($query6);
}
echo  json_encode($output);

?>