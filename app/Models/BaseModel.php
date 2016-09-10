<?php
/**
 * @File BaseModel.php
 * @Project quikr_prod.
 * @Author: atiwari@quikr.com
 * @Date: 13/5/15
 * @Time: 1:03 PM
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Response;

class BaseModel extends Model
{
	/* make a curl call to APIs for post requests
	 *
	 * @param endpoint string : API's url.
	 * @param type string : post/get
	 * @param input json
	 * @param encryptionMethod string
	 * @return array
	 *  0 => status int : http response code
	 *  1 => response json
	 */
	public function curlApiCall($apiEndPoint, $type, $input = '', $encryptionMethod = 'ON')
	{
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $apiEndPoint);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, strtoupper($type));

		if ("POST" == strtoupper($type)) {
			curl_setopt($ch, CURLOPT_POSTFIELDS, $input);

			$headerPost = array(
				'Accept: application/json',
				'Content-Type: application/json;charset=utf8',
                'X-Quikr-Client: RealEstate.Desktop',
				'Content-Length: ' . strlen($input)
			);

			if ('ON' == $encryptionMethod) {
				array_push($headerPost, 'Accept-Encoding: gzip, deflate');
			}

			/*if (!empty($specialHeader)) {
				array_push($headerPost, $specialHeader);
			}*/

			curl_setopt($ch, CURLOPT_HTTPHEADER, $headerPost);
		} else {
			curl_setopt($ch, CURLOPT_HTTPHEADER, array('X-Quikr-Client: RealEstate.Desktop'));
		}
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

		$response = curl_exec($ch);
		$status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
		return array(
			"status" => $status,
			"response" => $response
		);
	}

	/*
	 * return json to the client/browser
	 *
	 * @param output array
	 * @return response
	 */
	public function sendJson($output){
		return response()->json($output)->header("Cache-Control","max-age=300");
	}
}