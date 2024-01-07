<?php
require("vendor/autoload.php");
require("conf.php");
use ezsql\Database;
use Carbon\Carbon;

$db = Database::initialize('mysqli', ["root", "", "lna", []], "");

if(isset($_GET['timezone_offset'])){
    $now = Carbon::now($_GET['timezone_offset']);
}
else{
    $now = Carbon::now();
}

if(isset($_GET['start_date']) && isset($_GET['location']))
{
    $meetings = $db->get_results("SELECT * FROM meetings where start_date > ".$_GET['start_date']." and location= '".$_GET['location']."';");
}
else if(isset($_GET['start_date'])){
    $meetings = $db->get_results("SELECT * FROM meetings where start_date > ".$_GET['start_date'].";");
}
else if(isset($_GET['location'])){
    $meetings = $db->get_results("SELECT * FROM meetings where location = '".$_GET['location']."';");
}
if(empty($meetings)){
    $meetings = $db->get_results("SELECT * FROM meetings ;");
}

?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>24 HR NA</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://www.gstatic.com/charts/loader.js"></script>

</head>
<body style="background:url('logo.png');background-repeat:no-repeat;background-attachment: fixed;background-position: center;">
<h1 class="text-center">24 HR NA</h1>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
<form style="top: 75px;position: fixed;left: 50%;transform: translate(-50%, -50%);" class="text-center" action="index.php" method="GET">
    <select name="timezone_offset" id="timezone-offset" class="span5">
        <option value="-12:00">(GMT -12:00) Eniwetok, Kwajalein</option>
        <option value="-11:00">(GMT -11:00) Midway Island, Samoa</option>
        <option value="-10:00">(GMT -10:00) Hawaii</option>
        <option value="-09:50">(GMT -9:30) Taiohae</option>
        <option value="-09:00">(GMT -9:00) Alaska</option>
        <option value="-08:00">(GMT -8:00) Pacific Time (US &amp; Canada)</option>
        <option value="-07:00">(GMT -7:00) Mountain Time (US &amp; Canada)</option>
        <option value="-06:00">(GMT -6:00) Central Time (US &amp; Canada), Mexico City</option>
        <option value="-05:00">(GMT -5:00) Eastern Time (US &amp; Canada), Bogota, Lima</option>
        <option value="-04:50">(GMT -4:30) Caracas</option>
        <option value="-04:00">(GMT -4:00) Atlantic Time (Canada), Caracas, La Paz</option>
        <option value="-03:50">(GMT -3:30) Newfoundland</option>
        <option value="-03:00">(GMT -3:00) Brazil, Buenos Aires, Georgetown</option>
        <option value="-02:00">(GMT -2:00) Mid-Atlantic</option>
        <option value="-01:00">(GMT -1:00) Azores, Cape Verde Islands</option>
        <option value="+00:00" selected="selected">(GMT) Western Europe Time, London, Lisbon, Casablanca</option>
        <option value="+01:00">(GMT +1:00) Brussels, Copenhagen, Madrid, Paris</option>
        <option value="+02:00">(GMT +2:00) Kaliningrad, South Africa</option>
        <option value="+03:00">(GMT +3:00) Baghdad, Riyadh, Moscow, St. Petersburg</option>
        <option value="+03:50">(GMT +3:30) Tehran</option>
        <option value="+04:00">(GMT +4:00) Abu Dhabi, Muscat, Baku, Tbilisi</option>
        <option value="+04:50">(GMT +4:30) Kabul</option>
        <option value="+05:00">(GMT +5:00) Ekaterinburg, Islamabad, Karachi, Tashkent</option>
        <option value="+05:50">(GMT +5:30) Bombay, Calcutta, Madras, New Delhi</option>
        <option value="+05:75">(GMT +5:45) Kathmandu, Pokhara</option>
        <option value="+06:00">(GMT +6:00) Almaty, Dhaka, Colombo</option>
        <option value="+06:50">(GMT +6:30) Yangon, Mandalay</option>
        <option value="+07:00">(GMT +7:00) Bangkok, Hanoi, Jakarta</option>
        <option value="+08:00">(GMT +8:00) Beijing, Perth, Singapore, Hong Kong</option>
        <option value="+08:75">(GMT +8:45) Eucla</option>
        <option value="+09:00">(GMT +9:00) Tokyo, Seoul, Osaka, Sapporo, Yakutsk</option>
        <option value="+09:50">(GMT +9:30) Adelaide, Darwin</option>
        <option value="+10:00">(GMT +10:00) Eastern Australia, Guam, Vladivostok</option>
        <option value="+10:50">(GMT +10:30) Lord Howe Island</option>
        <option value="+11:00">(GMT +11:00) Magadan, Solomon Islands, New Caledonia</option>
        <option value="+11:50">(GMT +11:30) Norfolk Island</option>
        <option value="+12:00">(GMT +12:00) Auckland, Wellington, Fiji, Kamchatka</option>
        <option value="+12:75">(GMT +12:45) Chatham Islands</option>
        <option value="+13:00">(GMT +13:00) Apia, Nukualofa</option>
        <option value="+14:00">(GMT +14:00) Line Islands, Tokelau</option>
    </select>
    <select name="start_time">
        <option value="0">00:00</option>
        <option value="1">01:00</option>
        <option value="2">02:00</option>
        <option value="3">03:00</option>
        <option value="4">04:00</option>
        <option value="5">05:00</option>
        <option value="6">06:00</option>
        <option value="7">07:00</option>
        <option value="8">08:00</option>
        <option value="9">09:00</option>
        <option value="10">10:00</option>
        <option value="11">11:00</option>
        <option value="12">12:00</option>
        <option value="13">13:00</option>
        <option value="14">14:00</option>
        <option value="15">15:00</option>
        <option value="16">16:00</option>
        <option value="17">17:00</option>
        <option value="18">18:00</option>
        <option value="19">19:00</option>
        <option value="20">20:00</option>
        <option value="21">21:00</option>
        <option value="22">22:00</option>
        <option value="23">23:00</option>
        <option value="24">24:00</option>
    </select>
    <select name="location">
        <option>Location</option>
    </select>
    <input type="submit" value="Look Up" />
</form>
<br><br>
<ul class="list-group" style="    width: 25%;
    margin-left: auto;
    margin-right: auto;
    opacity: 0.8;
">
<?php
foreach($meetings as $meeting)
    {
        ?>
            <li style="margin-top:100px;" class="list-group-item">
                <table class="table">
                    <tbody>
                    <tr>
                        <td><img style="width:100%;" src="<?php echo $meeting->chart; ?>" /></td>
                    </tr>
                    <tr>
                        <td><?php echo $meeting->name; ?></td>
                    </tr>
                    <tr>
                        <td><?php echo $meeting->day; ?> <?php echo $meeting->time; ?></td>
                    </tr>
                    <tr>
                        <td><?php echo $meeting->location; ?></td>
                    </tr>
                    </tbody>
                </table>
            </li>
        <?php
    }
?>
</ul>
</body>
</html>