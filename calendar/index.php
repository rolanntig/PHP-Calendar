<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/style.css">
    <title>Kalenderapplikation</title>
    <style>
        .sunday {
            color: red;
        }

        .week-number {
            font-weight: bold;
            color: #007bff;
        }
    </style>
</head>

<body>
    <div class="calendarContainer">
        <div class="monthContainer">
            <form method="get">
                <button type="submit" name="action" value="back">&lt;</button>
                <h2><?php echo date('F Y', strtotime($_GET['date'])); ?></h2>
                <button type="submit" name="action" value="forward">&gt;</button>
                <input type="hidden" name="date" value="<?php echo $_GET['date']; ?>">
            </form>
        </div>
        <div class="calendar">
            <table>
                <?php
                $jsonData = file_get_contents('namnsdagar.json');
                $namnsdagar = json_decode($jsonData, true);

                $string = "";
                $parsedDate = htmlspecialchars($_GET["date"]);
                $monthIndex = date('n', strtotime($parsedDate));
                $firstDayOfMonth = date('Y-m-01', strtotime($parsedDate));
                $lastDayOfMonth = date('Y-m-t', strtotime($parsedDate));


                $currentDate = $firstDayOfMonth;

                while ($currentDate <= $lastDayOfMonth) {
                    $dayName = date('l', strtotime($currentDate));
                    $date = date('j', strtotime($currentDate));
                    $weekNumber = (date('N', strtotime($currentDate)) == 1) ? date('W', strtotime($currentDate)) : '';
                    $dayNumber = date('z', strtotime($currentDate)) + 1;
                    $class = (date('N', strtotime($currentDate)) == 7) ? 'sunday' : '';
                    $dayOfYear = date('z', strtotime($currentDate));
                    $namn = isset($namnsdagar[$dayOfYear]) ? implode(', ', $namnsdagar[$dayOfYear]) : 'Ingen namnsdag';

                    $string .= "<tr><td>{$date} (Dag {$dayNumber})</td><td class='$class'>$dayName</td><td>$namn</td><td class='week-number'>$weekNumber</td></tr>";
                    $currentDate = date('Y-m-d', strtotime($currentDate . ' +1 day'));
                }
                echo ($string);

                if (isset($_GET['action']) && ($_GET['action'] == 'back' || $_GET['action'] == 'forward')) {
                    $currentDate = $_GET['date'];
                    if ($_GET['action'] == 'back') {
                        $currentDate = date('Y-m', strtotime("$currentDate -1 month"));
                    } else {
                        $currentDate = date('Y-m', strtotime("$currentDate +1 month"));
                    }
                    header("Location: {$_SERVER['PHP_SELF']}?date={$currentDate}");
                    exit;
                }
                ?>
            </table>
        </div>
    </div>
</body>

</html>
