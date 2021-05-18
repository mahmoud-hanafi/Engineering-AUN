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
	global $base_url;
	$sql = "SELECT * FROM `member` WHERE `Faculty_Code` = 02 and M_ID =759 LIMIT 0,1" ;
	//$sql = "SELECT * FROM `int_news` inner join int_pics using(int_id) WHERE `fac_ID` = 02 ORDER BY int_id asc LIMIT 0,10" ;
    $database = \Drupal::database();
    $result = $database->query($sql);
    $i =1;
    while ($row_data = $result->fetchAssoc()) {
	  print $i." s- ";
	  $username     	=  $row_data['M_Full_EName'];
	  $username_ar     	=  $row_data['M_Full_AName'];
	  $M_ID    			=  $row_data['M_ID'];
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
	  $M_E_Address    	=  $row_data['M_E_Address'];
	  $M_Tele_Home    	=  $row_data['M_Tele_Home'];
	  $M_Mobile    		=  $row_data['M_Mobile'];
	  $M_Tel_Office    	=  $row_data['M_Tel_Office'];
	  $M_Tele_Fax     	=  $row_data['M_Tele_Fax'];
	  $Dept_Code    	=  $row_data['Dept_Code'];
	  $google_scholar	=  $row_data['google_scholar'];
	  
	  // getting user user education
	  $user_education = "";
	  $education_sql = "SELECT * FROM `m_education` WHERE `M_ID` = $M_ID " ;
	  $database = \Drupal::database();
      $education_result = $database->query($education_sql);
      while ($education_row_data = $education_result->fetchAssoc()) {
		$Edu_University 	=  $education_row_data['Edu_University'];
		$Edu_Faculty 		=  $education_row_data['Edu_Faculty'];
		$Edu_Specific_Major =  $education_row_data['Edu_Specific_Major'];
		$Edu_Major 			=  $education_row_data['Edu_Major'];
		$Edu_CertificateYear =  $education_row_data['Edu_CertificateYear'];
		$Edu_ID 			=  $education_row_data['Edu_ID'];
		$Edu_Degree = db_query("SELECT Edu_Degree from education WHERE Edu_ID = :Edu_ID LIMIT 1", array(":Edu_ID" => $Edu_ID))->fetchField();
		$education_text = "$Edu_Degree In $Edu_Major ($Edu_Specific_Major) , $Edu_Faculty $Edu_University , $Edu_CertificateYear <br> ";
		$user_education = $user_education ." $education_text" ;
	  }
	  // getting user acadamic positions
	  $user_positions = "";
	  $position_sql = "SELECT * FROM `m_academic_pos` WHERE `M_ID` = $M_ID " ;
	  $database = \Drupal::database();
      $position_result = $database->query($position_sql);
      while ($position_row_data = $position_result->fetchAssoc()) {
		$Acd_Pos_Date 	=  $position_row_data['Acd_Pos_Date'];
		$Acd_Pos_Date   = explode('-',$Acd_Pos_Date);
		$Acd_Pos_Date   = $Acd_Pos_Date[0];
		$Acd_Pos_ID 	=  $position_row_data['Acd_Pos_ID'];
		$Acd_Pos_Dept 	=  $position_row_data['Acd_Pos_Dept'];
		$Acd_Pos_ETitle = db_query("SELECT Acd_Pos_ETitle from academic_pos WHERE Acd_Pos_ID = :Acd_Pos_ID LIMIT 1", array(":Acd_Pos_ID" => $Acd_Pos_ID))->fetchField();
		$position_text = "$Acd_Pos_ETitle Faculty of Engineering, Assiut University , $Acd_Pos_Date <br> ";
		$user_positions = $user_positions ." $position_text" ;
	  }
	  
	 // getting user adminstative positions
	  $admin_positions = "";
	  $admin_position_sql = "SELECT * FROM `m_admin_pos` WHERE `M_ID` = $M_ID " ;
	  $database = \Drupal::database();
      $admin_position_result = $database->query($admin_position_sql);
      while ($admin_position_row_data = $admin_position_result->fetchAssoc()) {
		$Pos_StartDate 	 =  $admin_position_row_data['Pos_StartDate'];
		$Pos_ID      	 =  $admin_position_row_data['Pos_ID'];
		$Pos_eTitle      = db_query("SELECT Pos_eTitle from admin_pos WHERE Pos_ID = :Pos_ID LIMIT 1", array(":Pos_ID" => $Pos_ID))->fetchField();
		$position_text   = "$Pos_eTitle Faculty of Engineering, Assiut University ,since $Pos_StartDate <br> ";
		$admin_positions = $admin_positions ." $position_text" ;
	  }
	  
	  $old_file_path = $row_data['M_Img_Data'];
	  $old_cv_file_path = $row_data['M_CV'];
	  $old_cv_file_path = $row_data['M_CV'];
	  $old_ar_cv_file_path = $row_data['M_aCV'];
	  //print $old_file_path;exit();
	  $old_file_path = explode('/',$old_file_path);
	  $img_name = end($old_file_path);
	  $file_image="D:\AUN\uploaded_imgs/$img_name";             
      $file_content = file_get_contents($file_image);
	  $directory = 'public://users/';
      file_prepare_directory($directory, FILE_CREATE_DIRECTORY);
      $file_image = file_save_data($file_content, $directory . basename($file_image),     FILE_EXISTS_REPLACE);
	  
	  $old_cv_file_path = explode('/',$old_cv_file_path);
	  $cv_name = end($old_cv_file_path);
	  $en_cv ="D:\AUN\CVs/$cv_name";             
      $file_content = file_get_contents($en_cv);
	  $directory = 'public://cvs/';
      file_prepare_directory($directory, FILE_CREATE_DIRECTORY);
      $en_cv_file = file_save_data($file_content, $directory . basename($en_cv),     FILE_EXISTS_REPLACE);
	   // arabic cv
	  $old_ar_cv_file_path = explode('/',$old_ar_cv_file_path);
	  $ar_cv_name = end($old_ar_cv_file_path);
	  $ar_cv ="D:\AUN\CVs/$ar_cv_name";             
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
	   'field_user_full_name' => array('value' =>$username),
	   'field_national_id' => array('value' =>$M_NID),
	   'field_user_gender' => array('value' =>$M_Gender),
	   'field_birth_date' => array('value' =>$M_Birthdate),
	   'field_place_of_birth' => array('value' =>$M_PlaceOfBirth),
	   'field_user_address' => array('value' =>$M_E_Address),
	   'field_home_telephone' => array('value' =>$M_Tele_Home),
	   'field_user_mobile' => array('value' =>$M_Mobile),
	   'field_telephone_office' => array('value' =>$M_Tel_Office),
	   'field_google_scholar' => array('value' =>$google_scholar),
	   'field_user_fax' => array('value' =>$M_Tele_Fax),
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
      ]);
	  $user->set("langcode", 'en');
	  $user->save();
	  $user_ar = $user->addTranslation('ar', $user->toArray());
	  //$user_ar = $user->addTranslation('ar');
	  $user_ar->set("field_user_full_name", "$username_ar");
	  //$user_ar->field_user_full_name->value = "$username_ar";
	  $user_ar->save();
	  $i++;
    }
	exit();
  }
}

