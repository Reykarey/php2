<?
if(file_exists("log/".PATH_LOG)){
    $logs = file("log/".PATH_LOG);
}
echo "<ol>";
    foreach($logs as $log_line){
        list($dt, $page, $ref) = explode(" -- ", $log_line);
        $dt = date("d-m-Y H:i:s", $dt);
        echo <<<OUT
        <li>
        [$dt] - $ref -> $page
        </li>
OUT;
    }
echo "</ol>";
