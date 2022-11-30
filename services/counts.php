


<?php
include("connection.php");

class Tehsil extends connection {
    function __construct()
    {
        $this->connectionDB();

    }

    public function getAllCounts() {

  //   $sql="select date_created::date,count(*) from demand_point where  date_created::date<>'2021-12-01' group by date_created::date order by date_created::date";where  a.date_created::date<>'2021-12-01'
    //   $sql="select b.username,count(*) from demand_point a inner join tbl_user_info b on a.user_id=b.user_id  and is_not_surveyed<>'Yes' group by b.username";
        $sql = "with foo as (select * from tbl_user) select c.username,count(a.installed_status) from tbl_survey_details a,
        tbl_meter b ,foo c where a.installation=b.installation_id and installed_status is not null and b.created_by::integer=c.id::integer
          group by c.username";
    $output = array();
        $result_query = pg_query($sql);
        if ($result_query) {
            $arrq = pg_fetch_all($result_query);
            $output['total']= $arrq;
            
                    
        }

        $sql = "with foo as (select * from tbl_user) select c.username,count(a.installed_status) from tbl_survey_details a,
        tbl_meter b ,foo c where a.installation=b.installation_id and installed_status is not null and b.created_by::integer=c.id::integer
        and installed_status='Installed' group by c.username";
        $result_query = pg_query($sql);
        if ($result_query) {
            $arrq = pg_fetch_all($result_query);
            $output['installed']= $arrq;
            
                    
        }
        // exit();
        $sql="with foo as (select * from tbl_user) select c.username,count(a.installed_status) from tbl_survey_details a,tbl_meter b ,
        foo c where a.installation=b.installation_id and installed_status is not null and b.created_by::integer=c.id::integer and 
        installed_status='Unsurveyed' group by c.username";
        //$output = array();
        $result_query = pg_query($sql);
        if ($result_query) {
            $arrq = pg_fetch_all($result_query);
            $output['submitted']= $arrq;
                    
        }

        $sql="with foo as (select * from tbl_user) select c.username,count(a.installed_status) from tbl_survey_details a,
        tbl_meter b ,foo c where a.installation=b.installation_id and installed_status is not null and b.created_by::integer=c.id::integer 
        and installed_status='TRAS' group by c.username";
        //$output = array();
        $result_query = pg_query($sql);
        if ($result_query) {
            $arrq = pg_fetch_all($result_query);
            $output['black']= $arrq;
                    
        }

        return json_encode($output);

        $this->closeConnection();
    }

    public function getTodayCounts() {

        //   $sql="select date_created::date,count(*) from demand_point where  date_created::date<>'2021-12-01' group by date_created::date order by date_created::date";
            $sql="with foo as (select * from tbl_user) select c.username,count(a.installed_status) from tbl_survey_details a,tbl_meter b ,foo c where a.installation=b.installation_id and installed_status is not null and b.created_by::integer=c.id::integer and b.updated_at::date = now()::date group by c.username";
              $output = array();
              $result_query = pg_query($sql);
              if ($result_query) {
                  $arrq = pg_fetch_all($result_query);
                  $output= $arrq;
                          
              }
      
              return json_encode($output);
      
              $this->closeConnection();
          }
 
              
              public function getDateCounts() {

                //   $sql="select date_created::date,count(*) from demand_point where  date_created::date<>'2021-12-01' group by date_created::date order by date_created::date";
                   // $sql="select b.username,a.updated_at::date,count(*) from demand_point a inner join tbl_user_info b on a.user_id=b.user_id where  a.user_id is not null and updated_at>'2022-02-07 02:43:44.20696' group by b.username,a.updated_at::date order by updated_at::date";
                     $sql = "with foo as (select * from tbl_user) select c.username,count(a.installed_status), b.updated_at
                     from tbl_survey_details a,tbl_meter b ,foo c where a.installation=b.installation_id 
                     and installed_status is not null and b.created_by::integer=c.id::integer and updated_at>now() 
                     group by c.username, b.updated_at";
                      $output = array();
                      $result_query = pg_query($sql);
                      if ($result_query) {
                          $arrq = pg_fetch_all($result_query);
                          $output= $arrq;
                                  
                      }
              
                      return json_encode($output);
              
                      $this->closeConnection();
                  }      

                  public function getTotal_Orders() {

                    //   $sql="select date_created::date,count(*) from demand_point where  date_created::date<>'2021-12-01' group by date_created::date order by date_created::date";
                        // $sql="select count(*) from demand_point where phase is not null and phase<>''";
                        $sql = "select count(*) from tbl_survey_details";
                          $output = array();
                          $result_query = pg_query($sql);
                          if ($result_query) {
                              $arrq = pg_fetch_all($result_query);
                              $output= $arrq;
                                      
                          }
                  
                          return json_encode($output);
                  
                          $this->closeConnection();
                      }    
                      
                    public function getTotal_Tras() {

                        //   $sql="select date_created::date,count(*) from demand_point where  date_created::date<>'2021-12-01' group by date_created::date order by date_created::date";
                            $sql="select count(*) from tbl_survey_details where installed_status='TRAS'";
                              $output = array();
                              $result_query = pg_query($sql);
                              if ($result_query) {
                                  $arrq = pg_fetch_all($result_query);
                                  $output= $arrq;
                                          
                              }
                      
                              return json_encode($output);
                      
                              $this->closeConnection();
                    }
                    
                    public function getTotal_notInstalled() {

                        //   $sql="select date_created::date,count(*) from demand_point where  date_created::date<>'2021-12-01' group by date_created::date order by date_created::date";
                            $sql="select count(*) from tbl_survey_details where installed_status='Unsurveyed'";
                              $output = array();
                              $result_query = pg_query($sql);
                              if ($result_query) {
                                  $arrq = pg_fetch_all($result_query);
                                  $output= $arrq;
                                          
                              }
                      
                              return json_encode($output);
                      
                              $this->closeConnection();
                    }
                    
                    public function getTotal_siteInfo() {

                        //   $sql="select date_created::date,count(*) from demand_point where  date_created::date<>'2021-12-01' group by date_created::date order by date_created::date";
                            // $sql="select count(*) from demand_point where phase is null or phase =''";
                            $sql="select count(*) from tbl_survey_details where installed_status='Installed'";
                              $output = array();
                              $result_query = pg_query($sql);
                              if ($result_query) {
                                  $arrq = pg_fetch_all($result_query);
                                  $output= $arrq;
                                          
                              }
                      
                              return json_encode($output);
                      
                              $this->closeConnection();
                    }

                    public function getTotal_installed() {

                            //   $sql="select date_created::date,count(*) from demand_point where  date_created::date<>'2021-12-01' group by date_created::date order by date_created::date";
                                $sql="select installed_status ,count(installed_status)  
                                from tbl_survey_details where installed_status is not null
                                and installed_status<>'' group by installed_status order by installed_status ASC";
                                  $output = array();
                                  $result_query = pg_query($sql);
                                  if ($result_query) {
                                      $arrq = pg_fetch_all($result_query);
                                      $output['cat_total']= $arrq;
                                              
                                  }
                                  $sql1="select count(*) from tbl_survey_details";
                                  $result_query1 = pg_query($sql1);
                                  if ($result_query1) {
                                      $arrq1 = pg_fetch_all($result_query1);
                                      $output['overall_total']= $arrq1;
                                              
                                  }
                          
                                  return json_encode($output);
                          
                                  $this->closeConnection();
                    }    
                    
                    public function getAll_Users() {

                            $sql="select id,username from tbl_user";
                              $output = array();
                              $result_query = pg_query($sql);
                              if ($result_query) {
                                  $arrq = pg_fetch_all($result_query);
                                  $output= $arrq;
                                          
                              }
                      
                              return json_encode($output);
                      
                              $this->closeConnection();
                }  
                
                public function getByTime_Users($date) {                  
                    $sql="select username, updated_at,sum(total) as count from (
                    select b.username,date_part('hour', a.updated_at) as updated_at  ,count(*) as total  from demand_point a inner join 
                    tbl_user_info b on a.user_id=b.user_id where  a.user_id is not null and updated_at::date='$date'
                    group by b.username, updated_at order by updated_at
                    ) as foo group by username,updated_at  order by updated_at";
					
					//echo $sql;
                      $output = array();
                      $result_query = pg_query($sql);
                      if ($result_query) {
                          $arrq = pg_fetch_all($result_query);
                          $output= $arrq;
                                  
                      }
              
                      return json_encode($output);
              
                      $this->closeConnection();
        }       
}

$json = new Tehsil();
//$json->closeConnection();
if($_GET['id']=='all'){
echo $json->getAllCounts();
}else if($_GET['id']=='today'){
    echo $json->getTodayCounts();
}else if($_GET['id']=='date'){
    echo $json->getDateCounts();
}else if($_GET['id']=='total_orders'){
    echo $json->getTotal_Orders();
}
else if($_GET['id']=='today_tras'){
    echo $json->getTotal_tras();
}
else if($_GET['id']=='total_not_installed'){
    echo $json->getTotal_notInstalled();
}
else if($_GET['id']=='site_info'){
    echo $json->getTotal_siteInfo();
}else if($_GET['id']=='total_installed'){
    echo $json->getTotal_installed();
}else if($_GET['id']=='users'){
    echo $json->getAll_Users();
}else if($_GET['id']=='time'){
    $t_date=$_GET['d'];
    echo $json->getByTime_Users($t_date);
}



