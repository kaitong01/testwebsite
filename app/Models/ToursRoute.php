<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class ToursRoute extends Model
{
  protected $table = 'tour_route';
  public $primatyKey = 'id';
  public $itemstamps = false;

  protected $fillable = [
    'name',
    'description',
    'created_uid',
    'updated_uid',
    'seo_title',
    'seo_description',
    'link',
    'country',
    'seq',
    'status'];



  private $_findKeyword = ['q', 'status'];
  private $_sort = 'updated_at';
  private $_dir = 'desc';



  public function _conditions(&$options)
  {

      foreach ($this->_findKeyword as $key) {
          if( isset($request->{$key}) ) $options[$key] = $request->{$key};
      }

      $options = array_merge(array(
          'sort' => isset($_REQUEST['sort'])? $_REQUEST['sort']: $this->_sort,
          'dir' => isset($_REQUEST['dir'])? $_REQUEST['dir']: $this->_dir,

          'ts'=> isset($_REQUEST['time'])? $_REQUEST['time']:time(),
      ), $options);


      $params = '';


      return [
          // 'str'=> "{$where} {$groupby} {$having} {$orderby} {$limit}",
          'params' => $params
      ];

  }
}
