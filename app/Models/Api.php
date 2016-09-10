<?php
/**
 * @File Api.php
 * @Project quikr_prod.
 * @Author: saravanan.m@quikr.com
 * @Date: 07/01/16
 * @Time: 6:00 PM
 */

namespace App\Models;
use App\Models\BaseModel;

class Api extends BaseModel
{
	/*formats the values received from the post ad form
	 *
	 * @param $attr array : attribute received from from
	 * @param $isMulti boolean : whether attribute receives multiple values
	 * @return string
	 */
	public function getRequirement($id) {
		return $this->curlApiCall(config('constants.GET_REQUIREMENT_ID') . "realestate/v1/getRequirement?requirementId=" . $id, 'GET');
	}
    public function updateRequirement($input)
	{
	   return $this->curlApiCall(config('constants.GET_REQUIREMENT_ID')."realestate/v1/updateRequirement", 'POST', $input);
	}
    public function updateEmailRequirement($input)
	{
	   return $this->curlApiCall(config('constants.GET_REQUIREMENT_ID')."realestate/v1/updateRequirementEmail", 'POST', $input);
	}
    public function updateMobileRequirement($input)
    {
	   return $this->curlApiCall(config('constants.GET_REQUIREMENT_ID')."realestate/v1/updateMobileNumber", 'POST', $input);
	}
    public function emailHistory($req_id)
	{
	   return $this->curlApiCall(config('constants.GET_REQUIREMENT_ID')."realestate/v1/getEmailHistory?requirementId=".$req_id, 'GET');
	}
    public function mobileHistory($req_id)
    {
        return $this->curlApiCall(config('constants.GET_REQUIREMENT_ID')."realestate/v1/getPhoneHistory?requirementId=".$req_id, 'GET');
	}
    public function getCity() {
		return $this->curlApiCall(config('constants.GET_REQUIREMENT_ID') . "realestate/v1/cities", 'GET');
	}
    public function getProjects($cityid,$project) {
		return $this->curlApiCall(config('constants.GET_REQUIREMENT_ID') . "realestate/v1/project/find?cityId=". $cityid."&query=".$project, 'GET');
	} 
    public function getProjectdetails($projectid) {
		return $this->curlApiCall(config('constants.GET_REQUIREMENT_ID') . "realestate/v1/project?id=".$projectid, 'GET');
	} 
    public function getLocations($loc,$cityid) {
		return $this->curlApiCall(config('constants.GET_REQUIREMENT_ID') . "realestate/v1/locality/search?query=". $loc."&cityId=".$cityid, 'GET');
	} 
	public function getLocationCompetency($cityid) {
		return $this->curlApiCall(config('constants.GET_REQUIREMENT_ID') . "realestate/v1/locality/getLocalities?cityId=".$cityid, 'GET');
	} 
	public function getProjectCompetency($localityId) {
		return $this->curlApiCall(config('constants.GET_REQUIREMENT_ID') . "realestate/v1/project/getProjectsByLocality?localityId=".$localityId, 'GET');
	} 
	public function matchMakingAPi($req_id){
		return $this->curlApiCall(config('constants.GET_MATCHMAKING_ID') . "realestate/v1/matchingProjectsForRequirement?requirementId=".$req_id, 'GET');
	} 
	public function SMSAPI($Number,$content){
		$content = rawurlencode($content);
		return $this->curlApiCall("http://alerts.solutionsinfini.com/api/v3/index.php?method=sms&api_key=Ac46a45e9226f609f73d8a504d6e30e8d&to=".$Number."&sender=QUIKRH&message=".$content."&format=json&custom=1&flash=0", 'GET');
	}    
}
