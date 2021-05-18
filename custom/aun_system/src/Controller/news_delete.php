<?php
namespace Drupal\aun_system\Controller;
use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Component\Utility\UrlHelper;
use Drupal\node\Entity\Node;
use Drupal\Core\Url;

class news_delete extends  ControllerBase{
  public function handle_news_delete(){
	global $base_url;
	$sql = "SELECT nid FROM node_field_data WHERE `type` = 'awards'" ;
	//$sql = "SELECT * FROM `int_news` inner join int_pics using(int_id) WHERE `fac_ID` = 02 ORDER BY int_id asc LIMIT 0,10" ;
	
    $database = \Drupal::database();
    $result = $database->query($sql);
    $i =1;
    while ($row_data = $result->fetchAssoc()) {
	  $news_nid = $row_data['nid'];
	  //print $news_nid;exit();
	  $node = Node::load($news_nid);
	// or
	  $node = \Drupal::entityTypeManager()->getStorage('node')->load($news_nid);
	  if ($node) {
		$node->delete();
	  print $news_nid." -  ";
	  }
	  print $i."<br>";
	  $i++;
	  
    }
	exit();
  }
}

