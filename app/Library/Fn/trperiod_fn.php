<?php
class TrPeriod_Fn extends Fn
{
	public function set_tr($data)
	{
			$m =["มกราคม","กุมภาพันธ์","มีนาคม","เมษายน","พฤษภาคม","มิถุนายน","กรกฎาคม","สิงหาคม","กันยายน","ตุลาคม","พฤศจิกายน","ธันวาคม"];
			$output = "";
			$head_date ="";

			foreach ($data as  $row) {
					$sdate = $row->start_date;
					$edate = $row->end_date;
					$month = date_create($sdate);
					$month = date_format($month,"m");
					$year = substr($data,0,4);

					if($head_date!==$sdate){
							// dd($month);
						$output = '<tr>
							<td colspan="3">'.(!empty($m[$month])? $m[$month]: '').' '.$year.'</td>
						</tr>';
					$month_s = date_create($sdate);
					$month_s = date_format($month_s,"n");
					$month_e = date_create($edate);
					$month_e = date_format($month_e,"n");
					$day_s =  substr($sdate,8,2);
					$day_e =  substr($edate,8,2);

					$year_s = substr($sdate,0,4);
					$year_e = substr($edate,0,4);
					if($head_date!==$month_s){

						$output .= '<tr><td colspan="3" class="text-center">'.$m[$month_s].' '.$year_e.'</td></tr>';

					}
					if($month_s==$month_e){
						$output .= '<tr><td>'.$day_s.' - '.$day_e.' '.$m[$month_e] .' '.$year_e.'</td><td class="text-right">'.number_format($row->price_at).'.-</td><td class="text-right">'.number_format($row->price_at).'.-</td></tr>';
					}else{
						$output .= '<tr><td>'.$day_s.' '.$m[$month_s] .''.' - '.$day_e.' '.$m[$month_e] .' '.$year_e.'</td><td class="text-right">'.number_format($row->price_at).'.-</td><td class="text-right">'.number_format($row->price_at).'.-</td></tr>';
					}





					$head_date = $month_s;
			}

			return $output;
	}

	public function country_name($id){
		$db = DB::table('countries')->where('country_id',$id)->first();
		if($db==null){
		$rs =  "ไม่พบข้อมูลประเทศ ID: ".$id ;
		}else{
			$rs =  $db->country_name;
		}
		return $rs;
	}


}
