<?php
namespace Drupal\aun_system\Controller;
use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Component\Utility\UrlHelper;
use Drupal\node\Entity\Node;
use Drupal\Core\Url;
use \Drupal\user\Entity\User;

class users_update extends  ControllerBase{
  public function handle_users_update(){
	global $base_url; // LIMIT 0,3
	//$sql = "SELECT * FROM `member` WHERE `Faculty_Code` = 02 and M_ID =656" ;
	$sql = "SELECT uid FROM `users` WHERE `uid` > 1  " ;
    $database = \Drupal::database();
    $result = $database->query($sql);
    $i =1;
    while ($row_data = $result->fetchAssoc()) {
	  print $i." s- ";
	  $uid     	        =  $row_data['uid'];
	  print $uid;
	  $user_account = \Drupal\user\Entity\User::load("$uid"); // pass your uid
	  //$user_account->delete();
	  $old_id = $user_account->get('field_old_member_id')->value;
	  //print $old_id;exit();
	  //print_r($user_account);exit();
	  //print $uid." - "; 
	  //$user_dep = db_query("SELECT dep.entity_id FROM `node__field_old_department_id` dep inner JOIN member m on m.Dept_Code=dep.`field_old_department_id_value` inner join user__field_old_member_id u on u.field_old_member_id_value = m.M_ID where u.entity_id = :uid LIMIT 1", array(":uid" => $uid))->fetchField();
	  //print $user_dep." </br>";
	  //$user_account->field_user_department->entity = $user_dep;
	  //print_r($user_account);exit();
	  
	 // getting user supervisor
	 print " - ".$old_id;
	 $i=1;
	 $x= 1;
	 $admin_supervisor    = "";
	 $admin_supervisor_ar = "";
	 $admin_supervisor_sql = "SELECT * FROM `m_thesis` WHERE `M_ID` = $old_id " ;
	 $database = \Drupal::database();
	 $admin_supervisor_result = $database->query($admin_supervisor_sql);
	 while ($admin_supervisor_row_data = $admin_supervisor_result->fetchAssoc()) {
	   $Thesis_ID      	 =  $admin_supervisor_row_data['Thesis_ID'];
	   $Th_eTitle     		 = db_query("SELECT Th_eTitle from thesis WHERE Thesis_ID = :Thesis_ID LIMIT 1", array(":Thesis_ID" => $Thesis_ID))->fetchField();
	   $Th_eResearcher      = db_query("SELECT Th_eResearcher from thesis WHERE Thesis_ID = :Thesis_ID LIMIT 1", array(":Thesis_ID" => $Thesis_ID))->fetchField();
	   $Th_eSupervisors     = db_query("SELECT Th_eSupervisors from thesis WHERE Thesis_ID = :Thesis_ID LIMIT 1", array(":Thesis_ID" => $Thesis_ID))->fetchField();
	   $Th_Award_Date       = db_query("SELECT Th_Award_Date from thesis WHERE Thesis_ID = :Thesis_ID LIMIT 1", array(":Thesis_ID" => $Thesis_ID))->fetchField();
	   $supervisor_text     = "$i- $Th_eResearcher , $Th_eTitle ,$Th_Award_Date <br>
							   supervisor: $Th_eSupervisors";
	   $admin_supervisor   = $admin_supervisor." $supervisor_text <br><br>" ;
	   
	   $Th_aTitle     		 = db_query("SELECT Th_aTitle from thesis WHERE Thesis_ID = :Thesis_ID LIMIT 1", array(":Thesis_ID" => $Thesis_ID))->fetchField();
	   $Th_aResearcher      = db_query("SELECT Th_aResearcher from thesis WHERE Thesis_ID = :Thesis_ID LIMIT 1", array(":Thesis_ID" => $Thesis_ID))->fetchField();
	   $Th_aSupervisors     = db_query("SELECT Th_aSupervisors from thesis WHERE Thesis_ID = :Thesis_ID LIMIT 1", array(":Thesis_ID" => $Thesis_ID))->fetchField();
	   $Th_Award_Date       = db_query("SELECT Th_Award_Date from thesis WHERE Thesis_ID = :Thesis_ID LIMIT 1", array(":Thesis_ID" => $Thesis_ID))->fetchField();
	   $supervisor_text_ar  = "$x - $Th_aResearcher , $Th_aTitle ,$Th_Award_Date <br>
							   المشرفون: $Th_aSupervisors";
	   $admin_supervisor_ar = $admin_supervisor_ar." $supervisor_text_ar <br><br>" ;
	   $i++;
	  }
	  //print $admin_supervisor;exit();
	  $user_account->field_member_supervisions->value = $admin_supervisor;
	  $user_account->field_member_supervisions->format = 'full_html';
	  $user_account->save();
	  print $x;
	  $x++;
	  
    }
	exit();
  }
}

