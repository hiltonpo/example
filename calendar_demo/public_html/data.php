<?php
include('../db.php');

 try {
   $pdo = new PDO("mysql:host=$db[host];dbname=$db[dbname];port=$db[port];charset=$db[charset]", 
   $db['username'], $db['password']);
}   catch (PDOException $e) {
    echo "Database connection failed lol.";
     exit;
}

$year = date('Y');
$month= date('m');

// load events
$sql = 'SELECT id, title, `date`, start_time FROM events WHERE year=:year AND month=:month ORDER BY `date`, start_time ASC';
$statement = $pdo->prepare($sql);
$statement->bindValue(':year', $year, PDO::PARAM_INT);
$statement->bindValue(':month', $month, PDO::PARAM_INT);
$statement->execute();

$events = $statement->fetchAll(PDO::FETCH_ASSOC);
// 10:00:00 -> 10:00
foreach ($events as $key => $event) {
    $events[$key]['start_time'] = substr($event['start_time'], 0, 5);
}


// 這個月有幾天 28或29或30或31天?
$days = cal_days_in_month (CAL_GREGORIAN, $month, $year);

// calculate paddings

// 1 號是星期幾?
$firstDateOfTheMonth = new DateTime("$year-$month-1");
// 最後一天是星期幾?
$lastDateOfTheMonth = new DateTime("$year-$month-$days");
// calendar 要填的 padding
$frontPadding = $firstDateOfTheMonth->format('w'); // 0-6 
$backPadding = 6 - $lastDateOfTheMonth->format('w');
// 填 前面的 padding
for ($i=0; $i < $frontPadding; $i++) {
    $dates[] = null;
}
// 填 1-31
for ($i=0; $i < $days; $i++) {
    $dates[] = $i+1;
}
// 填 後面的 padding
for ($i=0; $i < $backPadding; $i++) {
    $dates[] = null;
}

?>

<script>
    var events = <?= json_encode($events, JSON_NUMERIC_CHECK) ?>;
</script>

