<?php

namespace mysql;
use mysqli;

class mySql
{
    private function side($x1, $y1, $z1, $x2, $y2, $z2)
    {
        $x = abs($x1 - $x2);
        $y = abs($y1 - $y2);
        $z = abs($z1 - $z2);
        return round(sqrt($x * $x + $y * $y + $z * $z), 2);
    }

    private function corners($a, $b, $c)
    {
        $cosA = ($c * $c + $b * $b - $a * $a) / (2 * $c * $b);
        $cosB = ($c * $c + $a * $a - $b * $b) / (2 * $c * $a);
        $cosC = ($a * $a + $b * $b - $c * $c) / (2 * $a * $b);
        return [round(acos($cosA) * 57.3), round(acos($cosB) * 57.3), round(acos($cosC) * 57.3)];
    }

    private function validate($a, $b, $c)
    {
        if ($a > $b + $c || $b > $a + $c || $c > $b + $a)
        {
            return false;
        }
        return true;
    }

    private function square($a, $b, $c)
    {
        if (!$this->validate($a, $b, $c))
        {
            return false;
        }
        $p = ($a + $b + $c) / 2;
        return round(sqrt($p * ($p - $a) * ($p - $b) * ($p - $c)), 2);
    }

    /**
     * @param float $ax
     * @param float $ay
     * @param float $az
     * @param float $bx
     * @param float $by
     * @param float $bz
     * @param float $cx
     * @param float $cy
     * @param float $cz
     */
    public function connectToMysql($ax, $ay, $az, $bx, $by, $bz, $cx, $cy, $cz)
    {
        $server =  "localhost";
        $username = "root";
        $password = "";

        $connection = new mysqli($server, $username, $password);

        $sql = "CREATE DATABASE IF NOT EXISTS mathDB";

        if ($connection->query($sql) === true) {
            $connection = new mysqli($server, $username, $password, "mathDB");
        }

        $table = "CREATE TABLE IF NOT EXISTS points(
            id BIGINT PRIMARY KEY AUTO_INCREMENT,
            side_a DOUBLE,
            side_b DOUBLE,
            side_c DOUBLE,
            square DOUBLE,
            angle1 DOUBLE,
            angle2 DOUBLE,
            angle3 DOUBLE
        )";

        $connection->query($table);

        $sideOne = $this->side($ax, $ay, $az, $bx, $by, $bz);
        $sideTwo = $this->side($cx, $cy, $cz, $bx, $by, $bz);
        $sideThree = $this->side($ax, $ay, $az, $cx, $cy, $cz);

        $square = $this->square($sideOne, $sideTwo, $sideThree);

        /**
        Если треугольник существует, то отправляем данные в таблицу
         * */
        if ($square) {
            list($corner1, $corner2, $corner3) = $this->corners($sideOne, $sideTwo, $sideThree);
            $insert = "INSERT INTO points(side_a, side_b, side_c, square, angle1, angle2, angle3)
            VALUES(". $sideOne . ",". $sideTwo . ",". $sideThree . ","
                . $square . ",". $corner1 . ",". $corner2 . ","
                . $corner3 . ")";
            $connection->query($insert);
        }

        $select = "SELECT * FROM points";
        $result = $connection->query($select);

        $answer = "";
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $answer .= '<p class="temporary"><span>sides = ' . $row["side_a"] ."; " . $row["side_b"] ."; " . $row["side_c"] . "; "
                    . '</span><span">S = ' . $row["square"] . '</span><span> Angles = ' . $row["angle1"] . '; ' .
                    $row["angle2"] . '; ' . $row["angle3"] . '</span></p>';
            }
        }

        $connection->close();

        return $answer;
    }
}