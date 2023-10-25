<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/style.css">
    <style>
        .sunday {
            color: red;
        }
    </style>
    <title>Document</title>
</head>
<body>
    <div class="calendarContainer">
        <div class="monthContainer">
            <form method="get">
                <button type="submit" name="action" value="back"><</button>
                <h2><?php echo date('F', strtotime($_GET['date'])); ?></h2>
                <button type="submit" name="action" value="forward">></button>
                <input type="hidden" name="date" value="<?php echo $_GET['date']; ?>">
            </form>
        </div>
        <div class="calendar">
            <table>
                <?php 
                    $string = "";
                    $parsedDate = htmlspecialchars($_GET["date"]);
                    $firstDayOfMonth = date('Y-m-01', strtotime($parsedDate));
                    $lastDayOfMonth = date('Y-m-t', strtotime($parsedDate));

                    $currentDate = $firstDayOfMonth;

                    while($currentDate <= $lastDayOfMonth){
                        $dayName = date('l', strtotime($currentDate));
                        $date = date('j', strtotime($currentDate));
                        $weekNumber = (date('N', strtotime($currentDate)) == 1) ? date('W', strtotime($currentDate)) : ''; 
                        $class = (date('N', strtotime($currentDate)) == 7) ? 'sunday' : ''; 
                        $string .= "<tr><td>{$date}</td><td class='$class'>$dayName</td><td>$weekNumber</td></tr>";
                        $currentDate = date('Y-m-d', strtotime($currentDate . ' +1 day'));
                    }
                    echo($string);

                    if(isset($_GET['action']) && $_GET['action'] == 'back'){
                        $currentDate = $_GET['date'];
                        $previousMonth = date('Y-m', strtotime("$currentDate -1 month"));
                        header("Location: {$_SERVER['PHP_SELF']}?date={$previousMonth}");
                        exit;
                    } elseif(isset($_GET['action']) && $_GET['action'] == 'forward'){
                        $currentDate = $_GET['date'];
                        $nextMonth = date('Y-m', strtotime("$currentDate +1 month"));
                        header("Location: {$_SERVER['PHP_SELF']}?date={$nextMonth}");
                        exit;
                    }
                ?>
            </table>
        </div>
    </div>
</body>
</html>
