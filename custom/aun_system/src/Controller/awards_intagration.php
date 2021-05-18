<?php
namespace Drupal\aun_system\Controller;
use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Component\Utility\UrlHelper;
use Drupal\node\Entity\Node;
use Drupal\Core\Url;

class awards_intagration extends  ControllerBase{
  public function handle_awards_intagration(){
	global $base_url;
	$awards_sql = "SELECT * FROM `m_awards` WHERE `Fac_Code` = 02  " ;
	//print $awards_sql;exit();
	$database = \Drupal::database();
    $awards_result = $database->query($awards_sql);
    while ($awards_data = $awards_result->fetchAssoc()) {
	  $Award_aTitle 	 =  $awards_data['Award_aTitle'];
	  $Award_eTitle 	 =  $awards_data['Award_eTitle'];
	  $Award_aField 	 =  $awards_data['Award_aField'];
	  $Award_eField 	 =  $awards_data['Award_eField'];
	  $Award_Date 	     =  $awards_data['Award_Date'];
	  $Date 		 	 =  $awards_data['Date'];
	  $Award_Category	 =  $awards_data['Award_Category'];
	  $Award_ID 	 	 =  $awards_data['Award_ID'];
	  $AwF_ID		 	 =  $awards_data['AwF_ID'];
	  $M_ID 			 =  $awards_data['M_ID'];
	  $user_id           = db_query("SELECT entity_id from user__field_old_member_id WHERE field_old_member_id_value = :M_ID LIMIT 1", array(":M_ID" => $M_ID))->fetchField();
//print $user_id;exit();
	  //$ 	 =  $awards_data[''];
	  $Cat_ETitle      = db_query("SELECT Cat_ETitle from award_cat WHERE Award_Cat_ID = :Award_Category LIMIT 1", array(":Award_Category" => $Award_Category))->fetchField();
	  $Cat_ATitle      = db_query("SELECT Cat_ATitle from award_cat WHERE Award_Cat_ID = :Award_Category LIMIT 1", array(":Award_Category" => $Award_Category))->fetchField();
	  $Award_Cat_eTitle = db_query("SELECT Award_eTitle from awards WHERE Award_ID = :Award_ID LIMIT 1", array(":Award_ID" => $Award_ID))->fetchField();
	  $Award_Cat_aTitle = db_query("SELECT Award_aTitle from awards WHERE Award_ID = :Award_ID LIMIT 1", array(":Award_ID" => $Award_ID))->fetchField();
          
   	  
		/////////////
	  if(empty($Award_eTitle)){	
	  //exit();
		if(empty($Award_aTitle)){ 
		     //return;
		  $Award_aTitle = 'جائزة'; 
		}
		$node = array();
	    $node = Node::create([
		  'type' => 'awards',
          'langcode' => 'ar',
		  'created' => \Drupal::time()->getRequestTime(),
		  'changed' => \Drupal::time()->getRequestTime(),
		  'uid' => $user_id,
		  'status' => 1,
		  'title' => "$Award_aTitle",
		  'field_award_category' => [
			'value' => "$Award_Category",
		  ],
		  'field_award_date' => [
			'value' => "$Date",
		  ],
		  'field_award_year' => [
		     'value' => "$Award_Date",
		  ],
	      'field_award_field' => [
	        'value' => "$Award_aField",
		  ],
	      'field_award_field_category' => [
			'value' => "$AwF_ID",
		  ],
	      'field_awards_member' => [
	        'target_id' => "$user_id",
		  ],
	    ]);
	    $node->save();
	  }else{  
	    $node = array();
	    $node = Node::create([
		  'type' => 'awards',
		  'langcode' => 'en',
		  'created' => \Drupal::time()->getRequestTime(),
		  'changed' => \Drupal::time()->getRequestTime(),
		  'uid' => $user_id,
		  'status' => 1,
		  'title' => "$Award_eTitle",
		  'field_award_category' => [
		    'value' => "$Award_Category",
		  ],
		  'field_award_date' => [
		    'value' => "$Date",
		  ],
		  'field_award_year' => [
	         'value' => "$Award_Date",
		  ],
		  'field_award_field' => [
			'value' => "$Award_EField",
		  ],
		  'field_award_field_category' => [
			'value' => "$AwF_ID",
		  ],
	      'field_awards_member' => [
	        'target_id' => "$user_id",
		  ],
	    ]);
	    //print_r($node);exit();
	    $node->save();
        $node_ar = $node->addTranslation('ar');
        $node_ar->title = $Award_aTitle;
	    //$node_ar->user->uid = $user_id;
	    $node_ar->field_award_field->value = "$Award_AField";
		  //$node_ar->field_event_time->value = "$event_time";
		  //$node_ar->field_event_image->target_id = $file3->id();
		$node_ar->save();
		//print $node->id();exit();
      }  
	}
	exit();
  }
}

