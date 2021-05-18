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
	$sql = "SELECT uid FROM `users` WHERE `uid` > 1 " ;
    $database = \Drupal::database();
    $result = $database->query($sql);
    $i =1;
	$department = array( "0201"=>208 , "0202"=>209 , "0203"=>210 , "0204"=>211, "0205"=>212 );
    while ($row_data = $result->fetchAssoc()) {
	  //print $i." s- ";
	  $uid     	        =  $row_data['uid'];
	  $user_account = \Drupal\user\Entity\User::load("$uid"); // pass your uid
	  $old_id = $user_account->get('field_old_member_id')->value;
	  //print $old_id;exit();
	  //print_r($user_account);exit();
	  print $uid." - "; 
	  $user_dep = db_query("SELECT dep.entity_id FROM `node__field_old_department_id` dep inner JOIN member m on m.Dept_Code=dep.`field_old_department_id_value` inner join user__field_old_member_id u on u.field_old_member_id_value = m.M_ID where u.entity_id = :uid LIMIT 1", array(":uid" => $uid))->fetchField();
	  print $user_dep;
	  $user_account->field_user_department->entity = $user_dep;
	  //print_r($user_account);exit();
	  $user_account->save();
	  //$i++;
    }
	exit();
  }
}

