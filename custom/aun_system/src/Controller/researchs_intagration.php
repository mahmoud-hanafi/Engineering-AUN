<?php
namespace Drupal\aun_system\Controller;
use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Component\Utility\UrlHelper;
use Drupal\node\Entity\Node;
use Drupal\Core\Url;

class researchs_intagration extends  ControllerBase{
  public function handle_researchs_intagration(){
	global $base_url;
	$department = array( "0202"=>208 , "0201"=>209 , "0205"=>210 , "0203"=>211, "0204"=>212 );
    $research_sql = "SELECT * FROM `m_research` inner join research using(Research_ID) WHERE `Research_Faculty` = '02' " ;
	$database = \Drupal::database();
    $research_result = $database->query($research_sql);
    while ($research_data = $research_result->fetchAssoc()) {
	  $Research_ID	 	 	 =  $research_data['Research_ID'];
	  $Date	 	 			 =  $research_data['Date'];
	  $Research_Dept	 	 =  $research_data['Research_Dept'];
	  $Research_Authors	 	 =  $research_data['Research_Authors'];
	  $Research_Title	 	 =  $research_data['Research_Title'];
	  $Research_Year	 	 =  $research_data['Research_Year'];
	  $Research_Journal	 	 =  $research_data['Research_Journal'];
	  $Research_Publisher	 =  $research_data['Research_Publisher'];
	  $Research_Vol	 		 =  $research_data['Research_Vol'];
	  $Research_Pages	 	 =  $research_data['Research_Pages'];
	  $Research_Rank	 	 =  $research_data['Research_Rank'];
	  $Research_Abstract	 =  $research_data['Research_Abstract'];
	  $Research_FileData	 =  $research_data['Research_FileData'];
	  $Research_kw	 	 	 =  $research_data['Research_kw'];
	  $full_txt	 	 		 =  $research_data['full_txt'];
	  $Research_Website	 	 =  $research_data['Research_Website'];
	  $M_ID	 	 			 =  $research_data['M_ID'];
	  $Dept_nid         	 =  $department["$Research_Dept"];
	  $user_id               = db_query("SELECT entity_id from user__field_old_member_id WHERE field_old_member_id_value = :M_ID LIMIT 1", array(":M_ID" => $M_ID))->fetchField();
	  print $user_id."<br>";

	  $old_cv_file_path = $row_data['M_CV'];
	  $old_cv_file_path = $row_data['M_CV'];
	  //$old_ar_cv_file_path = ;
	  //print $old_file_path;exit();
	  $old_file_path = explode('/',$full_txt);
	  $img_name = end($old_file_path);
	  $file_image="E:/xampp/htdocs/AUN/AUN/uploaded_full_txt/$img_name";             
      $file_content = file_get_contents($file_image);
	  //print $file_content; print "<br>";
	  $directory = 'public://researches/';
      file_prepare_directory($directory, FILE_CREATE_DIRECTORY);
      $full_txt_file = file_save_data($file_content, $directory . basename($file_image),     FILE_EXISTS_REPLACE);
	  $full_txt_file_id = $full_txt_file->id();
	  //$old_cv_file_path = explode('/',$old_cv_file_path);
	  //$cv_name = end($old_cv_file_path);
      $cv_name = "$Research_ID.pdf";
	  $en_cv ="E:/xampp/htdocs/AUN/AUN/reserches_files/$cv_name";             
      $file_content = file_get_contents($en_cv);
	  $directory = 'public://researches/';
      file_prepare_directory($directory, FILE_CREATE_DIRECTORY);
	  $en_cv_file = file_save_data($file_content, $directory . basename($en_cv),     FILE_EXISTS_REPLACE);
	  $en_cv_file_id = $en_cv_file->id();
	  //print_r($en_cv_file);exit();
	   // arabic cv
	  //$old_ar_cv_file_path = explode('/',$old_ar_cv_file_path);
	  //$ar_cv_name = end($old_ar_cv_file_path);
	  $ar_cv_name = "$Research_ID.doc";
	  $ar_cv ="E:/xampp/htdocs/AUN/AUN/reserches_files/$ar_cv_name";             
      $file_content = file_get_contents($ar_cv);
	  $directory = 'public://researches/';
      file_prepare_directory($directory, FILE_CREATE_DIRECTORY);
	  $ar_cv_file = file_save_data($file_content, $directory . basename($ar_cv),     FILE_EXISTS_REPLACE);	  
	  $ar_cv_file_id = $ar_cv_file->id();
	  //$ 	 =  $awards_data[''];
		/////////////
	  if(!empty($Research_Title)){	
	  //exit();
	  //print $Research_Title;exit();
		$node = array();
	    $node = Node::create([
		  'type' => 'research',
          'langcode' => 'en',
		  'created' => \Drupal::time()->getRequestTime(),
		  'changed' => \Drupal::time()->getRequestTime(),
		  'uid' => $user_id,
		  'status' => 1,
		  'title' => "$Research_Title",
		  'field_research_authors' => [
			'value' => "$Research_Authors",
		  ],
		  'field_researches_abstract' => [
			'value' => "$Research_Abstract",
		  ],
		  'field_research_date' => [
			'value' => "$Date",
		  ],
		  'field_research_department' => [
			'target_id' => "$Dept_nid",
		  ],
		  'field_research_journal' => [
			'value' => "$Research_Journal",
		  ],
		  'field_research_publisher' => [
			'value' => "$Research_Publisher",
		  ],
		  'field_research_rank' => [
			'value' => "$Research_Rank",
		  ],
		  'field_research_vol' => [
			'value' => "$Research_Vol",
		  ],
		  'field_research_website' => [
			'value' => "$Research_Website",
		  ],
		  'field_research_year' => [
			'value' => "$Research_Year",
		  ],
		  'field_research_pages' => [
			'value' => "$Research_Pages",
		  ],
		 // 'field_research_file' => array('target_id' =>407,'target_id' =>1298),

		  'field_research_user' => [
	        'target_id' => "$user_id",
		  ],
		]);
		if(is_numeric($ar_cv_file_id)){
			$node->field_research_file->appendItem($ar_cv_file_id);
		}
		if(is_numeric($en_cv_file_id)){
			$node->field_research_file->appendItem($en_cv_file_id);
		}
		if(is_numeric($full_txt_file_id)){
			$node->field_research_file->appendItem($full_txt_file_id);
		}
		//$node->field_research_file->appendItem(407);
		//$node->field_research_file->appendItem(1298);
	    $node->save();
	  }  
	}
	//exit();
  }
}


