<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Item;
use App\ItemVariant;
use DB;

class APIController extends Controller
{
	public function get_item_data(Request $request){
		$last_updated_date = $request->last_updated_date??"2000-01-01";
		$total_item = $request->total_item??0;

		$response = array();
		$response['success']="false";
		$response['data']=array();
		//[{"item_code":"BPL60A01","variant_code":"NC53","item_name":"POLISHED BPL-60A01 60 X 60\/NC53","item_base_unit_1_id":"DUS","base_1_to_base_2":"1.44000000000000000000"},
		$data = array();
		// Test database connection
		$no_variant_item = Item::doesnthave('itemVariants')->get();
		foreach ($no_variant_item as $key => $nvi) {
			$temp_data = array(
				"item_code"=>$nvi["No_"],
				"variant_code"=>"",
				"item_name"=>$nvi["Description"],
				"item_base_unit_1_id"=>$nvi["Base Unit of Measure"],
				"base_1_to_base_2"=>$nvi["Konversi M2"],
			);
			array_push($data, $temp_data);
		}
		$variant_item = Item::has('itemVariants')->get();
		foreach ($variant_item as $key => $vi) {
			foreach ($vi->itemVariants as $key => $var) {
				$temp_data = array(
					"item_code"=>$vi["No_"],
					"variant_code"=>$var["Code"],
					"item_name"=>$vi["Description"]."/".$var["Code"]." ".$vi["Description 2"],
					"item_base_unit_1_id"=>$vi["Base Unit of Measure"],
					"base_1_to_base_2"=>$vi["Konversi M2"],
				);
				array_push($data, $temp_data);

			}

			
		}
		//if($request->total_item??0<count($data)){
			$response['success']="true";
			$response['data']=$data;
		//}
		return json_encode($response);


	}
}
