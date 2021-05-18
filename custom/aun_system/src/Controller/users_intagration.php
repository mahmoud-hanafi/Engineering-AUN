<?php
namespace Drupal\aun_system\Controller;
use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Component\Utility\UrlHelper;
use Drupal\node\Entity\Node;
use Drupal\Core\Url;
use \Drupal\user\Entity\User;

class users_intagration extends  ControllerBase{
  public function handle_users_intagration(){
	global $base_url; // LIMIT 0,3 692 610
	$sql = "SELECT * FROM `member` WHERE `Faculty_Code` = 02 and `M_ID` > 691" ;
	//print $sql;exit();
    $database = \Drupal::database();
    $result = $database->query($sql);
    $i =1;
	$department = array( "0202"=>208 , "0201"=>209 , "0205"=>210 , "0203"=>211, "0204"=>212 );
    while ($row_data = $result->fetchAssoc()) {
	  print $i." s- ";
	  $username     	=  $row_data['M_Full_EName'];
	  if($username == "")
	  $username     	=  $row_data['M_Full_AName'];
	  $username_ar     	=  $row_data['M_Full_AName'];
	  $M_ID    			=  $row_data['M_ID'];
	  print $M_ID." </br>";
	  $m_stauts  		=  $row_data['present'];
	  $position_title   = db_query("SELECT Acd_Pos_ETitle from academic_pos inner join m_academic_pos m using(Acd_Pos_ID) WHERE m.M_ID = :M_ID order by m.ID Desc LIMIT 1", array(":M_ID" => $M_ID))->fetchField();
	  $position_title   =  substr($position_title , 0,4);
	  $position_title_ar = db_query("SELECT Acd_Pos_ATitle from academic_pos inner join m_academic_pos m using(Acd_Pos_ID) WHERE m.M_ID = :M_ID order by m.ID Desc LIMIT 1", array(":M_ID" => $M_ID))->fetchField();
      //print $postiotn_title;exit();
	  $username 		= "$position_title.$username";
	  $username_ar 		= "$position_title_ar/.$username_ar";
	  //print $username;exit();
	  $userpassword 	=  '123456';
	  $useremail    	=  $row_data['M_AUN_Email'];
	  $M_MIS_Email    	=  $row_data['M_MIS_Email'];
	  $M_Email      	=  $row_data['M_Email'];
	  $M_NID		   	=  $row_data['M_NID'];
	  $M_Gender       	=  $row_data['M_Gender'];
	  $M_Birthdate      =  $row_data['M_Birthdate'];
	  $M_PlaceOfBirth   =  $row_data['M_PlaceOfBirth'];
	  $M_A_PlaceOfBirth =  $row_data['M_A_PlaceOfBirth'];
	  $M_E_Address    	=  $row_data['M_E_Address'];
	  $M_A_Address    	=  $row_data['M_A_Address'];
	  $M_Tele_Home    	=  $row_data['M_Tele_Home'];
	  $M_Mobile    		=  $row_data['M_Mobile'];
	  $M_Tel_Office    	=  $row_data['M_Tel_Office'];
	  $M_Tele_Fax     	=  $row_data['M_Tele_Fax'];
	  $Dept_Code    	=  $row_data['Dept_Code'];
	  $Dept_nid         =  $department["$Dept_Code"];
	  //print_r($department);exit();
	  $google_scholar	=  $row_data['google_scholar'];
	  /*
	  if(empty($useremail)){
		  $useremail = $M_Email;
	  }elseif(empty($useremail) and empty($M_Email)){
		 $useremail = $M_Email;
	  }
	  */
	  // getting user user education
	  $user_education = "";
	  $user_education_ar = "";
	  $education_sql = "SELECT * FROM `m_education` WHERE `M_ID` = $M_ID " ;
	  $database = \Drupal::database();
      $education_result = $database->query($education_sql);
      while ($education_row_data = $education_result->fetchAssoc()) {
		$Edu_University 	=  $education_row_data['Edu_University'];
		$Edu_Faculty 		=  $education_row_data['Edu_Faculty'];
		$Edu_Specific_Major =  $education_row_data['Edu_Specific_Major'];
		$Edu_Major 			=  $education_row_data['Edu_Major'];
		$Edu_CertificateYear=  $education_row_data['Edu_CertificateYear'];
		$Edu_ID 			=  $education_row_data['Edu_ID'];
		$Edu_Degree 		= db_query("SELECT Edu_Degree from education WHERE Edu_ID = :Edu_ID LIMIT 1", array(":Edu_ID" => $Edu_ID))->fetchField();
		$education_text 	= "$Edu_Degree In $Edu_Major ($Edu_Specific_Major) , $Edu_Faculty $Edu_University , $Edu_CertificateYear <br> ";
		$user_education 	= " $education_text" .$user_education ;
		
		// select arabic education
		$Edu_A_University 		=  $education_row_data['Edu_A_University'];
		$Edu_A_Faculty 			=  $education_row_data['Edu_A_Faculty'];
		$Edu_Specific_A_Major	=  $education_row_data['Edu_Specific_A_Major'];
		$Edu_A_Major 			=  $education_row_data['Edu_A_Major'];
		$Edu_CertificateYear 	=  $education_row_data['Edu_CertificateYear'];
		$Edu_ID 				=  $education_row_data['Edu_ID'];
		$Edu_A_Degree 			= db_query("SELECT Edu_aDegree from education WHERE Edu_ID = :Edu_ID LIMIT 1", array(":Edu_ID" => $Edu_ID))->fetchField();
		$education_text_ar 		= "$Edu_A_Degree في  $Edu_A_Major ($Edu_Specific_A_Major) , $Edu_A_Faculty $Edu_A_University , $Edu_CertificateYear <br> ";
		$user_education_ar 		= " $education_text_ar <br>" .$user_education_ar;
	  }
	  // getting user acadamic positions
	  $user_positions = "";
	  $user_positions_ar = "";
	  $position_sql = "SELECT * FROM `m_academic_pos` WHERE `M_ID` = $M_ID " ;
	  $database = \Drupal::database();
      $position_result = $database->query($position_sql);
      while ($position_row_data = $position_result->fetchAssoc()) {
		$Acd_Pos_Date 	=  $position_row_data['Acd_Pos_Date'];
		$Acd_Pos_Date   = explode('-',$Acd_Pos_Date);
		$Acd_Pos_Date   = $Acd_Pos_Date[0];
		$Acd_Pos_ID 	=  $position_row_data['Acd_Pos_ID'];
		$Acd_Pos_Dept 	=  $position_row_data['Acd_Pos_Dept'];
		$Acd_Pos_Univ 	=  $position_row_data['Acd_Pos_Univ'];
		$Acd_Pos_ETitle = db_query("SELECT Acd_Pos_ETitle from academic_pos WHERE Acd_Pos_ID = :Acd_Pos_ID LIMIT 1", array(":Acd_Pos_ID" => $Acd_Pos_ID))->fetchField();
		$position_text 	= "$Acd_Pos_ETitle Faculty of Engineering, $Acd_Pos_Univ , $Acd_Pos_Date <br> ";
		$user_positions = " $position_text <br>".$user_positions;
		
		/// arabic user acadamic positions
		
		$Acd_Pos_A_Univ 	=  $position_row_data['Acd_Pos_A_Univ'];
		$Acd_Pos_ATitle 	= db_query("SELECT Acd_Pos_ATitle from academic_pos WHERE Acd_Pos_ID = :Acd_Pos_ID LIMIT 1", array(":Acd_Pos_ID" => $Acd_Pos_ID))->fetchField();
		$position_text_ar 	= "$Acd_Pos_ATitle كلية الهندسة , $Acd_Pos_A_Univ , $Acd_Pos_Date <br> ";
		$user_positions_ar 	=  " $position_text_ar <br>".$user_positions_ar ;
	  }
	  
	 // getting user adminstative positions
	  $admin_positions    = "";
	  $admin_positions_ar = "";
	  $admin_position_sql = "SELECT * FROM `m_admin_pos` WHERE `M_ID` = $M_ID " ;
	  $database = \Drupal::database();
      $admin_position_result = $database->query($admin_position_sql);
      while ($admin_position_row_data = $admin_position_result->fetchAssoc()) {
		$Pos_StartDate 	 =  $admin_position_row_data['Pos_StartDate'];
		$Pos_ID      	 =  $admin_position_row_data['Pos_ID'];
		$Pos_eTitle      = db_query("SELECT Pos_eTitle from admin_pos WHERE Pos_ID = :Pos_ID LIMIT 1", array(":Pos_ID" => $Pos_ID))->fetchField();
		$position_text   = "$Pos_eTitle Faculty of Engineering, Assiut University ,since $Pos_StartDate <br> ";
		$admin_positions = " $position_text <br>".$admin_positions ;
		
		$Pos_aTitle         = db_query("SELECT Pos_aTitle from admin_pos WHERE Pos_ID = :Pos_ID LIMIT 1", array(":Pos_ID" => $Pos_ID))->fetchField();
		$position_text_ar   = "$Pos_aTitle كلية الهندسة, جامعة اسيوط ,منذ   $Pos_StartDate <br> ";
		$admin_positions_ar = " $position_text_ar <br>".$admin_positions_ar ;
	  }
	  
	 // getting user adminstative positions
	  $admin_membership    = "";
	  $admin_membership_ar = "";
	  $admin_membership_sql = "SELECT * FROM `m_membership` WHERE `M_ID` = $M_ID " ;
	  $database = \Drupal::database();
      $admin_membership_result = $database->query($admin_membership_sql);
      while ($admin_membership_row_data = $admin_membership_result->fetchAssoc()) {
		$Organization 	 		=  $admin_membership_row_data['Organization'];
		$Membership_Type      	=  $admin_membership_row_data['Membership_Type'];
		$m_membership 			= $Membership_Type.$Organization;
		$admin_membership 		= " $m_membership </br> ".$admin_membership ;
		
		$aOrganization 	 		=  $admin_membership_row_data['aOrganization'];
		$Membership_aType    	=  $admin_membership_row_data['Membership_aType'];
		$m_membership_ar     	= $Membership_aType.$aOrganization;
		$admin_membership_ar 	= " $m_membership_ar </br>".$admin_membership_ar  ;
		
	  }
	  
	 // getting user supervisor
	  $x=1;
	  $admin_supervisor    = "";
	  $admin_supervisor_ar = "";
	  $admin_supervisor_sql = "SELECT * FROM `m_thesis` WHERE `M_ID` = $M_ID " ;
	  $database = \Drupal::database();
      $admin_supervisor_result = $database->query($admin_supervisor_sql);
      while ($admin_supervisor_row_data = $admin_supervisor_result->fetchAssoc()) {
		$Thesis_ID      	 =  $admin_supervisor_row_data['Thesis_ID'];
		$Th_eTitle     		 = db_query("SELECT Th_eTitle from thesis WHERE Thesis_ID = :Thesis_ID LIMIT 1", array(":Thesis_ID" => $Thesis_ID))->fetchField();
		$Th_eResearcher      = db_query("SELECT Th_eResearcher from thesis WHERE Thesis_ID = :Thesis_ID LIMIT 1", array(":Thesis_ID" => $Thesis_ID))->fetchField();
		$Th_eSupervisors     = db_query("SELECT Th_eSupervisors from thesis WHERE Thesis_ID = :Thesis_ID LIMIT 1", array(":Thesis_ID" => $Thesis_ID))->fetchField();
		$Th_Award_Date       = db_query("SELECT Th_Award_Date from thesis WHERE Thesis_ID = :Thesis_ID LIMIT 1", array(":Thesis_ID" => $Thesis_ID))->fetchField();
		$supervisor_text     = "1- $Th_eResearcher , $Th_eTitle ,$Th_Award_Date <br>
								supervisor: $Th_eSupervisors";
		$admin_supervisor   = $admin_supervisor." $supervisor_text <br><br>" ;
		
		$Th_aTitle     		 = db_query("SELECT Th_aTitle from thesis WHERE Thesis_ID = :Thesis_ID LIMIT 1", array(":Thesis_ID" => $Thesis_ID))->fetchField();
		$Th_aResearcher      = db_query("SELECT Th_aResearcher from thesis WHERE Thesis_ID = :Thesis_ID LIMIT 1", array(":Thesis_ID" => $Thesis_ID))->fetchField();
		$Th_aSupervisors     = db_query("SELECT Th_aSupervisors from thesis WHERE Thesis_ID = :Thesis_ID LIMIT 1", array(":Thesis_ID" => $Thesis_ID))->fetchField();
		$Th_Award_Date       = db_query("SELECT Th_Award_Date from thesis WHERE Thesis_ID = :Thesis_ID LIMIT 1", array(":Thesis_ID" => $Thesis_ID))->fetchField();
		$supervisor_text_ar  = "$x - $Th_aResearcher , $Th_aTitle ,$Th_Award_Date <br>
								المشرفون: $Th_aSupervisors";
		$admin_supervisor_ar = $admin_supervisor_ar." $supervisor_text_ar <br><br>" ;
		$x++;
	  }
	  $old_file_path = $row_data['M_Img_Data'];
	  $old_cv_file_path = $row_data['M_CV'];
	  $old_cv_file_path = $row_data['M_CV'];
	  $old_ar_cv_file_path = $row_data['M_aCV'];
	  //print $old_file_path;exit();
	  $old_file_path = explode('/',$old_file_path);
	  $img_name = end($old_file_path);
	  $file_image="E:/xampp/htdocs/AUN/AUN/uploaded_imgs/$img_name";             
      $file_content = file_get_contents($file_image);
	  $directory = 'public://users/';
      file_prepare_directory($directory, FILE_CREATE_DIRECTORY);
      $file_image = file_save_data($file_content, $directory . basename($file_image),     FILE_EXISTS_REPLACE);
	  
	  $old_cv_file_path = explode('/',$old_cv_file_path);
	  $cv_name = end($old_cv_file_path);
	  $en_cv ="E:/xampp/htdocs/AUN/AUN/CVs/$cv_name";             
      $file_content = file_get_contents($en_cv);
	  $directory = 'public://cvs/';
      file_prepare_directory($directory, FILE_CREATE_DIRECTORY);
      $en_cv_file = file_save_data($file_content, $directory . basename($en_cv),     FILE_EXISTS_REPLACE);
	  //print_r($en_cv_file);exit();
	   // arabic cv
	  $old_ar_cv_file_path = explode('/',$old_ar_cv_file_path);
	  $ar_cv_name = end($old_ar_cv_file_path);
	  $ar_cv ="E:/xampp/htdocs/AUN/AUN/CVs/$ar_cv_name";             
      $file_content = file_get_contents($ar_cv);
	  $directory = 'public://cvs/';
      file_prepare_directory($directory, FILE_CREATE_DIRECTORY);
      $ar_cv_file = file_save_data($file_content, $directory . basename($ar_cv),     FILE_EXISTS_REPLACE);
	  $user = User::create([
       'name' =>"$username",    
       'mail' => "$useremail",
       'pass' => "$userpassword",
	   //'langcode' => 'en',
       'status' => $m_stauts,
       'roles' => array('faculty_staff'),
       'field_team_image' => array('target_id' =>$file_image->id()),
	   'field_user_cv' => array('target_id' =>$en_cv_file->id()),
	   'field_user_cv_ar' => array('target_id' =>$ar_cv_file->id()),
	   'field_mis_email' => array('value' =>$M_MIS_Email),
	   'field_user_email' => array('value' =>$M_Email),
	   'field_old_member_id' => array('value' =>$M_ID),
	   'field_user_type' => array('value' =>0),
	   'field_user_full_name' => array('value' =>$username),
	   'field_national_id' => array('value' =>$M_NID),
	   'field_user_gender' => array('value' =>$M_Gender),
	   'field_birth_date_' => array('value' =>$M_Birthdate),
	   'field_place_of_birth' => array('value' =>$M_PlaceOfBirth),
	   'field_user_address' => array('value' =>$M_E_Address),
	   'field_home_telephone' => array('value' =>$M_Tele_Home),
	   'field_user_mobile' => array('value' =>$M_Mobile),
	   'field_telephone_office' => array('value' =>$M_Tel_Office),
	   'field_google_scholar' => array('value' =>$google_scholar),
	   'field_user_fax' => array('value' =>$M_Tele_Fax),
	   'field_user_department' => array('target_id' =>$Dept_nid),
	   'field_team_education' => array('value' =>$user_education),
	   'field_team_education' => [
			'value' => "$user_education",
			'format' => 'full_html',
		], 
	   'field_academic_positions' => [
			'value' => "$user_positions",
			'format' => 'full_html',
		], 
	   'field_administrative_positions' => [
			'value' => "$admin_positions",
			'format' => 'full_html',
		],
		'field_team_description' => [
			'value' => "$admin_positions",
			'format' => 'full_html',
		],
		'field_staff_membership' => [
			'value' => "$admin_membership",
			'format' => 'full_html',
		],
		'field_member_supervisions‎' => [
			'value' => "$admin_supervisor",
			'format' => 'full_html',
		],
	  ]);
	  /*
	  
	  if(is_numeric($file_image->id())){
		$user->field_team_image->targert_id = $file_image->id();
	  }
	  
	  if(is_numeric($en_cv_file->id())){
		$user->field_user_cv->targert_id = $en_cv_file->id();
	  }
	  
	  if(is_numeric($ar_cv_file->id())){
		$user->field_user_cv_ar->targert_id = $ar_cv_file->id();
	  }
	  if(is_numeric($file_image->id())){
		$user->field_team_image->appendItem($file_image->id());
	  }
	  
	  if(is_numeric($en_cv_file->id())){
		$user->field_user_cv->appendItem($en_cv_file->id());
	  }
	  
	  if(is_numeric($ar_cv_file->id())){
		$user->field_user_cv_ar->appendItem($ar_cv_file->id());
	  }
	  */
	  $user->set("langcode", 'en');
	  $user->save();
	  $user_id = $user->id();
	  $user_ar = $user->addTranslation('ar');
	  $user_ar->field_user_full_name->value = $username_ar;
	  $user_ar->field_team_education->value = $user_education_ar;
	  $user_ar->field_team_education->format = 'full_html';
	  $user_ar->field_academic_positions->value = $user_positions_ar;
	  $user_ar->field_academic_positions->format = 'full_html';
	  $user_ar->field_administrative_positions->value = $admin_positions_ar;
	  $user_ar->field_administrative_positions->format = 'full_html';
	  $user_ar->field_team_description->value = $admin_positions_ar;
	  $user_ar->field_team_description->format = 'full_html';
	  $user_ar->field_staff_membership->value = $admin_membership_ar;
	  $user_ar->field_staff_membership->format = 'full_html';
	  $user_ar->field_member_supervisions->value = $admin_supervisor_ar;
	  $user_ar->field_member_supervisions->format = 'full_html';
	  $user_ar->field_place_of_birth->value = $M_A_PlaceOfBirth;
	  $user_ar->save();
	  //$i++;
    }
	exit();
  }
}

