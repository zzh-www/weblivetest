
<?php
require_once('dbconnect.php');
    $str =$_SERVER["REQUEST_URI"];
    $link = db_connect();
    $arr = parse_url($str);

    $arr_query = convertUrlQuery($arr['query']);
    echo $arr_query['txt'];

    $roomid = 'chat';
    $sql = "select * from '$roomid' order by USERNAME";
    $result = mysqli_query($link, $sql);
    $array = array("result" => array());

    while ($row = mysqli_fetch_array($result)) {
        array_push($array["result"], json_encode($row));
    }
    echo $array;
    function convertUrlQuery($query)
    {
        $queryParts = explode('&', $query);

        $params = array();
        foreach ($queryParts as $param)
        {
            $item = explode('=', $param);
            $params[$item[0]] = $item[1];
        }

        return $params;
    }

    function getUrlQuery($array_query)
    {
        $tmp = array();
        foreach($array_query as $k=>$param)
        {
            $tmp[] = $k.'='.$param;
        }
        $params = implode('&',$tmp);
        return $params;
    }

?>