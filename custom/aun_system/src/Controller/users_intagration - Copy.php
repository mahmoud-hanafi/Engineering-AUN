<?php
namespace Drupal\aun_system\Controller;
use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Component\Utility\UrlHelper;
use Drupal\node\Entity\Node;
use Drupal\Core\Url;

class users_intagration extends  ControllerBase{
  public function handle_users_intagration(){
	global $base_url;
	$sql = "SELECT * FROM `member` WHERE `Faculty_Code` = 02 LIMIT 0,1" ;
	//$sql = "SELECT * FROM `int_news` inner join int_pics using(int_id) WHERE `fac_ID` = 02 ORDER BY int_id asc LIMIT 0,10" ;
    $database = \Drupal::database();
    $result = $database->query($sql);
    $i =1;
    while ($row_data = $result->fetchAssoc()) {
	print $i." s- ";
	  $username     =  $row_data['M_Full_EName'];
	  $useremail    =  $row_data['M_MIS_Email'];
	  $userpassword =  '123456';
	  
	  /*
	  $lang = \Drupal::languageManager()->getCurrentLanguage()->getId();
      $user = \Drupal\user\Entity\User::create();
 
      $user->setUsername("$useremail");  // You could also just set this to "Bob" or something...
      $user->setPassword("$userpassword");
      $user->setEmail("$useremail");
      $user->enforceIsNew();  // Set this to FALSE if you want to edit (resave) an existing user object
      $user->set("langcode", 'end');
      $user->set("preferred_langcode", 'en');
      $user->set("preferred_admin_langcode", 'en');
    //$user->set("setting_name", 'setting_value');
      $user->activate();
      $result = $user->save();
	  /*
	  $file_image='/var/www/html/drupal/sites/default/files/2017-04/images.jpeg';             

$file_content = file_get_contents($file_image);

$directory = 'public://Image/';

file_prepare_directory($directory, FILE_CREATE_DIRECTORY);

$file_image = file_save_data($file_content, $directory . basename($file_image),     FILE_EXISTS_REPLACE);

$user = User::create([

       'name' =>'user',    

       'mail' => 'user@gmail.com',

        'pass' => 'password',

        'status' => 1,

        'roles' => array('editor','administrator'),

        'user_picture' => array('target_id' =>$file_image->id()),

        'timezone'=> 'Indian/Christmas'

      ]);

$user->save();

	  $i++;
    }
	exit();
  }
}

