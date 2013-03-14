<?php if( ! defined('BASEPATH')) exit('No direct script access allowed');
class Lots_model extends CI_Model{
	function __construct()
	{
		parent::__construct();
	}
	
	function closest_lots($lot_lat, $lot_long, $max_lots)
	{
		$R = 6371; //km
		$distances = array();
		$all_lots = array();
		$top_lots = array();
		
		$this->db->select('id, latitude, longitude, name');
		$this->db->from('parkinglots');
		$result = $this->db->get();
		
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
		
			$count = 0;
			while($count < $max_lots):
				array_push($top_lots, $all_lots[$count]);
				$count = $count + 1;
			endwhile;
		}
		$lot_vals = array();
		foreach($top_lots as $data)
		{
			$ret = $this->occupancy($data['id']);
			$data['status'] = $ret;
			array_push($lot_vals, $data);
			
		}
		//error_log(print_r($lot_vals,1));
		$result->free_result();
		return $lot_vals;
	}
	
	function occupancy($lot_id)
	{
		$this->db->select('fill, check_in_time');
		$result = $this->db->get_where('entries', array('lot_id' => $lot_id));
		$past_val = array();
		$occ = array();
		$sum = 0;
		$posts = 0;
		foreach( $result->result_array() as $row){
			$status = array();
			$sum += $row['fill'];
			$status['occupancy'] = $row['fill'];
			$status['time'] = $row['check_in_time'];
			array_push($past_val, $status);
			$posts++;
		}
		if($posts == 0){
			$avg_occ = 0;
		}else{
			$avg_occ = ceil($sum/$posts);
		}
		$ret = $this->predicted($lot_id);
		//error_log('avg occ: '.$avg_occ);
		//error_log('ret val: '.$ret);
		$occ['avg_occ'] = $avg_occ;
		$occ['est_occ'] = $ret;
		$occ['past'] = $past_val;
		
			
		$result->free_result();
		return $occ;
	}
	
	function predicted($ref)
	{
		/**$this->db->select('fill');
		$this->db->from('entries');
		$this->db->where('id', $ref);
		//$this->db->where('check_in_time >=', 'DATE_ADD(NOW(), INTERVAL -  96 HOUR)');
		$result = $this->db->get();
		**/
		$where = "";
		$where .= "(lot_id = '$ref' AND check_in_time >= DATE_ADD(NOW(), INTERVAL -  24 HOUR))";
		$this->db->select('fill');
		//$this->db->where('id', $ref);
		$this->db->where($where);
		$result = $this->db->get('entries');
		//error_log(print_r($this->db->last_query(), 1));
		//$result = $this->db->get_where('entries', array('lot_id' => $ref));
		
		$posts = 0;
		$sum = 0;
		$trend = 0;
		$temp = 0;
		$avg_occ = 0;
		//error_log('Array Printout:');
		//error_log($result->num_rows());
		foreach( $result->result_array() as $row){
			$sum += $row['fill'];
			//error_log('fill: '.$row['fill']);
			if($row['fill'] > $temp)
			{
				$trend += 1;
			}elseif($row['fill'] < $temp)
			{
				$trend -= 1;
			}else{
				$trend += 0;
			}
			$posts++;
			$temp = $row['fill'];
			/**
			error_log('trend: '.$trend);
			error_log('temp; '.$temp);
			**/
		}
		
		if($posts == 0){
			$pred_val = 0;
		}else{
			$avg_occ = $sum/$posts;
			
			if($avg_occ >= 90 && $trend > 0){
				$pred_val = ceil($avg_occ + ((100 - $avg_occ) *($trend/$posts)));
			}elseif($avg_occ <= 10 && $trend < 0){
				$pred_val = ceil($avg_occ + ((0 + $avg_occ) * ($trend/$posts)));
			}else{
				$pred_val = ceil($avg_occ + (10 *($trend/$posts)));
			}
		}
		/**
		error_log('avg_occ: '.$avg_occ);
		error_log('trend: '.$trend);
		error_log('posts: '.$posts);
		error_log('est_occ: '.$pred_val);
		**/
		return $pred_val;
	
	}
	
	function lot_update($lot_id,$percent,$sender)
	{		
		$lot_data = array(
		'lot_id' 		=> 	$lot_id,
		'fill'	 		=>	$percent,
		'name'			=> 	$sender
		);
		error_log('Array: '. print_r($lot_data,1));
		$this->db->insert('entries', $lot_data);
	}
}
?>