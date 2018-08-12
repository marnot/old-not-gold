<?php
include 'airports.php';
?>
<form action="pdf.php" method="post">
    <fieldset>
        Select Departure Airport: <br>
        <select name="startPort">
            <?php
            foreach ($airports as $key => $port) {

                echo "<option value = " . $key . ">" .
                $port['name'] . " " . $port['code'] . "</option>";
            }
            ?>
        </select>
        <br>
        Select Arrival Airport: <br>
        <select name="endPort">
            <?php
            foreach ($airports as $key => $port) {

                echo "<option value = " . $key . ">" .
                $port['name'] . " " . $port['code'] . "</option>";
            }
            ?>
        </select>
    </fieldset>
    <fieldset>
        Please Select Flight Date: <br>
        <input type="datetime-local" name="startDate"> <br>
        Please Select Flight Time: <br>
        <input type="number" min="0" step="1" name="flightTime"> <br>
        Please Select Flight Price: <br>
        <input type="number" min="0" step="0.01" name="price"> <br>
        <input type="submit" value="Send">
    </fieldset>
</form>