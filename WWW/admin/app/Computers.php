<?php

class Computers
{
    public function getConn()
    {
        include_once("../../func/config.php");
		$con = mysqli_connect(DB_HOST,DB_UNAM,DB_PASW,DB_NAME);
		if (mysqli_connect_errno()){echo "Failed to connect to MySQL: " . mysqli_connect_error();}
        return $con;
    }
    
    public function getMC()
    {
        include_once("../../func/config.php");
        if (class_exists('Memcache'))
        {
            $mc = new Memcache;
            $mc->connect(MC_SERVER,MC_PORT);
            return $mc;
        }
        else
        {
            return false;
        }
    }
    
    public function getAll()
    {
        $con = $this->getConn();
        $query = "SELECT * FROM " . DB_COMPUTERS . " ORDER BY HOSTNAME ASC";
        $tmp = mysqli_query($con,$query);
        $result = array();
        while ($row = mysqli_fetch_assoc($tmp)) {
            array_push($result, $row);	
        }
        mysqli_close($con);
        return $result;
    }
    
	public function getAll_JSON()
    {
        include_once("compat/jsonwrapper.php");
        return json_encode($this->getAll());
    }
    
    /*
    public function getStatus($id)
    {
        if ($mc = $this->getMC())
        {
            if($result = $mc->get('openlabs_home_all'))
            {
            	return $result; 
            }
            else
            {
                return false;
            }
        }
        else
        {
        	return getAll();
        }
    }
    
    public function getStatus_JSON($id)
    {
        include_once('compat/jsonwrapper.php');
        return json_encode($this->getStatus($id));
    }
    
    public function getStatusAll()
    {
        if ($mc = $this->getMC())
        {
            if($result = $mc->get('openlabs_home_all'))
            {
            	return $result; 
            }
            else
            {
                if (!$result = $this->refreshStatusAll())
                {
                    return false;
                }
                else
                {
                    return $result;
                }
            }
        }
        else
        {
        	return getAll();
        }
    }
    
    public function getStatusAll_JSON()
    {
        include_once('compat/jsonwrapper.php');
        return json_encode($this->getStatusAll());
    }
    
    public function refreshStatusAll()
    {
        include_once('../../func/config.php');
        if ($mc = $this->getMC())
        {
            $con = $this->getConn();
            $tmp = mysqli_query($con,"SELECT * FROM `" . $DB_COMPUTERS . "` ORDER BY BUILDING ASC,ROOM ASC,COMPNO ASC");
            $result = array();
            while ($row = mysqli_fetch_assoc($tmp)) {
                array_push($result, $row);	
            }
            $mc->set('openlabs_home_all', $result, 0, 60);
            return $result;
        }
        else
        {
        	return false;
        }
        
    }
    */
    
    public function removeComp($id)
    {
        $con = $this->getConn();
        $query = "DELETE FROM " . DB_COMPUTERS . " WHERE `ID`=" . mysqli_real_escape_string($id) . ";";
        if (!mysqli_query($con,$query)){die('Error: ' . mysqli_error($con));}	
		mysqli_close($con);
    }
    
    public function removeComp_JSON($arr)
    {
        include_once("compat/jsonwrapper.php");
        $tmp = json_decode($arr);
        if (empty($arr))
        {
            return false;
        }
        $con = $this->getConn();
        $query = "DELETE FROM " . DB_COMPUTERS . " WHERE `ID` IN (0";
        foreach ($tmp as $id)
        {
            $query = $query . "," . mysqli_real_escape_string($con,$id);
        }
        $query = $query . ");";
        if (!mysqli_query($con,$query)){die('Error: ' . mysqli_error($con));}	
		mysqli_close($con);
    }
    
}

?>