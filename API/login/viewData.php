<?php
namespace Login;
use Login\fetchData;
class viewData extends fetchData
{
    public function IpStatus($ip)
    {
        $RecordsResult = $this->IpStatus_check($ip);
        return $RecordsResult;
    }

    public function CheckCredentials($Key, $User)
    {
        $RecordsResult = $this->UserLogin($Key, $User);
        return $RecordsResult;
    }
    public function CheckPermission($pass)
    {
        $RecordsResult = $this->UserPermission($pass);
        return $RecordsResult;
    }

}
