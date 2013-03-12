<?php if( ! defined('BASEPATH')) exit('No direct script access allowed');
class Lots_model extends CI_Model{
	function __construct()
	{
		parent::__construct();
	}
	
	function closest_lots($lot_lat, $lot_long, $max_lots)
	{
		$R = 6371; //km
		$this->db->select('latitude, longitude, name');
		$this->db->from('parkinglots');
		$result = $this->db->get();
		$distances = array();
		$all_lots = array();
		$top_lots = array();
		/**$max_lots = $ret_lots;
		if(!isset($max_lots)){
			$max_lots = 5;
		}**/
		if($result -> num_rows() > 0){
		
			foreach ($result->result_array() as $row)
			{
			/**
				Haversine formula:
				a = sin²(Δφ/2) + cos(φ1).cos(φ2).sin²(Δλ/2)
				c = 2.atan2(√a, √(1−a))
				d = R.c
			**/		
				$rad_lat = deg2rad($lot_lat - $row['latitude']);
				$rad_long = deg2rad($lot_long - $row['longitude']);
				$lat1 = deg2rad($lot_lat);
				$lat2 = deg2rad($row['latitude']);
				
				$a = (sin($rad_lat/2) * sin($rad_lat/2)) + ((sin($rad_long/2) * sin($rad_long/2)) * cos($lat1) * cos($lat2));
				$c = 2 * atan2(sqrt($a), sqrt(1-$a));
				$d = $R * $c;
				$row['distance'] = $d;
				array_push($all_lots,$row);
				array_push($distances,$d);
			}
		
			array_multisort($distances,SORT_STRING,$all_lots);
		
			//error_log(print_r($all_lots,1));
			$count = 0;
			while($count < $max_lots):
				//error_log('Lot '.$count.': '.$all_lots[$count]['name']. ' ' .$all_lots[$count]['distance']);
				array_push($top_lots, $all_lots[$count]);
				$count = $count + 1;
			endwhile;
		}
		error_log(print_r($top_lots,1));
		$result->free_result();
		return $top_lots;
	}
	
	function lot_update($lot_name,$percent)
	{
	$this->db->query("INSERT INTO enteries (fill) VALUES('$percent')");
	
	}
}
?>