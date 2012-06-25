<!--
To change this template, choose Tools | Templates
and open the template in the editor.
-->
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title></title>
    </head>
    <body>
        <?php

        function convert_number($number) {
            if (($number < 0) || ($number > 999999999)) {
                throw new Exception("Number is out of range");
            }

            $Gn = floor($number / 1000000);  /* Millions (giga) */
            $number -= $Gn * 1000000;
            $kn = floor($number / 1000);     /* Thousands (kilo) */
            $number -= $kn * 1000;
            $Hn = floor($number / 100);      /* Hundreds (hecto) */
            $number -= $Hn * 100;
            $Dn = floor($number / 10);       /* Tens (deca) */
            $n = $number % 10;               /* Ones */

            $res = "";

            if ($Gn) {
                $res .= convert_number($Gn) . " Million";
            }

            if ($kn) {
                $res .= (empty($res) ? "" : " ") .
                        convert_number($kn) . " Thousand";
            }

            if ($Hn) {
                $res .= (empty($res) ? "" : " ") .
                        convert_number($Hn) . " Hundred";
            }

            $ones = array("", "One", "Two", "Three", "Four", "Five", "Six",
                "Seven", "Eight", "Nine", "Ten", "Eleven", "Twelve", "Thirteen",
                "Fourteen", "Fifteen", "Sixteen", "Seventeen", "Eightteen",
                "Nineteen");
            $tens = array("", "", "Twenty", "Thirty", "Fourty", "Fifty", "Sixty",
                "Seventy", "Eigthy", "Ninety");

            if ($Dn || $n) {
                if (!empty($res)) {
                    $res .= " and ";
                }

                if ($Dn < 2) {
                    $res .= $ones[$Dn * 10 + $n];
                } else {
                    $res .= $tens[$Dn];

                    if ($n) {
                        $res .= "-" . $ones[$n];
                    }
                }
            }

            if (empty($res)) {
                $res = "zero";
            }

            return $res;
        }

        for ($i = 1; $i <= 2000; $i++) {
            echo $i . ", " . convert_number($i) . ", " . rand(1,10) . "<br>";
        }
        ?>
    </body>
</html>
