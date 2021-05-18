<?php
namespace Drupal\aun_system\Controller;
use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Component\Utility\UrlHelper;
use Drupal\node\Entity\Node;
use Drupal\Core\Url;
use Drupal\Core\Language\LanguageInterface;

class fast_category_search extends  ControllerBase{
  public function get_fast_category_search(){
    global $base_url;

 // print"ss";exit();
    //$content_type = \Drupal::request()->request->get('id');
    $category_id = $_GET['id'];
    $lang = $_GET['lang'];
    $language = \Drupal::languageManager()->getCurrentLanguage()->getId();
    $sql = "select  DISTINCT(link.entity_id) id ,field_category_link_uri uri , field_category_link_title title from node__field_category_link link inner join node__field_category_type cat using(entity_id) where cat.field_category_type_value = $category_id and link.langcode = '$lang' ";
    $database = \Drupal::database();
    $result = $database->query($sql);
    $i =1;
    $html_code = "<option value='All'> None</option>";
    while ($row_data = $result->fetchAssoc()) {
      $uri = $row_data['uri'];
      $name = $row_data['title'];
      $html_code .= "<option value =". $uri . ">" . $name  . "</option>";
    }
    print $html_code;exit();

  }
}

