<?php
require 'vendor/autoload.php';
include_once 'includes/airports.php';

use NumberToWords\NumberToWords;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if ($_POST['startPort'] != $_POST['endPort']) {

        if ($_POST['price'] > 0 && $_POST['startDate'] != '' && $_POST['flightTime'] != '') {

            //ports
            $home = $airports[$_POST['startPort']]['name'];
            $destination = $airports[$_POST['endPort']]['name'];
            $codeHome = $airports[$_POST['startPort']]['code'];
            $codeDest = $airports[$_POST['endPort']]['code'];

            //date, time, price    
            $startDate = $_POST['startDate'];
            $flightTime = $_POST['flightTime'];
            $price = $_POST['price'];

            //timezone
            $startTz = $airports[$_POST['startPort']]['timezone'];
            $endTz = $airports[$_POST['endPort']]['timezone'];

            //home tz
            $date = new DateTime($startDate);
            $homeTz = new DateTimeZone($startTz);
            $depTz = new DateTimeZone($endTz);
            $date->setTimezone($homeTz);
            $homeDate = $date->format('d.m.Y H:i:s');

            //dest tz
            $date->modify("+$flightTime hour");
            $date->setTimezone($depTz);
            $depDate = $date->format('d.m.Y H:i:s');

            //faker
            $faker = Faker\Factory::create();
            $name = $faker->name;
            //num-to-words
            $numberToWords = new NumberToWords();
            $numberTransformer = $numberToWords->getCurrencyTransformer('en');
            $wordPrice = $numberTransformer->toWords($price * 100, 'USD');

            $html = '
                <table>
                    <tr>
                        <th>Departure</th>
                        <th>Arrival</th>
                    </tr>
                    <tr>
                        <td>' . $home . ' ' . $codeHome . '<br>' . $homeDate . '</td>
                        <td>' . $destination . ' ' . $codeDest . '<br>' . $depDate . '</td>
                    </tr>
                    <tr>
                        <td>Flight Time: <br>' . $flightTime . ' hour(s)</td>
                        <td rowspan="2">Price: <br>' . $price . ' USD<br>
                        ' . $wordPrice . '</td>
                            
                    </tr>
                    <tr>
                        <td>Name: <br>' . $name . '</td>

                    </tr>
                </table>
            ';

            $mpdf = new mPDF();
            $stylesheet = file_get_contents('style.css');
            $mpdf->WriteHTML($stylesheet, 1);
            $mpdf->WriteHTML($html, 2);
            $mpdf->Output('flight.pdf', 'D');
        } else {
            echo 'Wrowadź poprawne dane!';
        }
    } else {
        echo 'Wybrano takie samo lotnisko wylotu i przylotu!<br>';
    }
}
?>

