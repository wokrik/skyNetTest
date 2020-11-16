<?
    // gets $amount of months
    // returns proper form of 'месяц' word
    function getMonthsDeclension($amount) {
        $lastDigit = intval(substr($amount, -1));
        $lastTwoDigits = intval(substr($amount, -2));
        if( 
            ($lastTwoDigits >= 10 && $lastTwoDigits <= 20) || // 10-20
            ($lastDigit > 5) || // 26-29, 36-39, ...
            ($lastDigit === 0)) { // 30, 40, 50, ...
                return " месяцев";
        }
        if($lastDigit === 1) { // 1, 21, 31, ...
            return " месяц";
        } else {
            return " месяца"; // 22-24, 32-34, ...
        }
    }
    
    // gets $url
    // returns parsed Json from $url address
    function parseJson($url) {
       $data = file_get_contents($url);
       $decodedData = json_decode($data);
       if($decodedData -> result === "ok") {
           return $decodedData;    
       } else {
           echo "Cannot get data from url " . $url;
       }
    }
    
    // gets tarif name, return related color
    function tarifNameToColor($tarifName) {
        $formatedName = explode(" ", $tarifName)[0];
        $formatedName = mb_strtolower($formatedName,'UTF-8');
        switch ($formatedName) {
            case "земля": return "brown"; break;
            case "вода": return "blue"; break;
            case "огонь": return "orange"; break;
            default: return 'empty';
        }
    }
?>