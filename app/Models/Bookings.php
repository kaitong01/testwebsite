<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class Bookings extends Model
{
  protected $table = 'booking';
  public $primatyKey = 'id';
  public $itemstamps = false;


  protected $fillable = [
    'booking_no',
    'booking_period',
    'booking_cus_fname',
    'booking_cus_lname',
    'booking_cus_email',
    'booking_cus_line',
    'booking_cus_tel',
    'booking_amount',
    'booking_company_id',
    'status',
  ];
}
