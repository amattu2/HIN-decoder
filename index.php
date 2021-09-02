<?php
# @Author: Alec M. <amattu>
# @Date:   2021-09-02
# @Last modified by:   amattu
# @Last modified time: 2021-09-02 11:07:22
# @License: GNU Affero General Public License v3.0
# @Copyright: Alec M.

// Include required files
require("classes/HIN.class.php");

// Example HINs
$HINS = ["YDV19777A808", "BMA45678H485", "STN34945E787", "XDV39777Z808", "XDV3777B808", "BMA45I78H485", "BMA45678HL85", "!TN34945E787"];

// Iterate through examples
foreach ($HINS as $index => $HIN) {
  echo "<h1>Example {$index}</h1>";

  try {
    // Instantiate HIN decoder
    $decoder = new amattu\HIN($HIN);

    // Example: toString
    echo "<h3>toString</h3>", $decoder;

    // Example: manufacturer_code
    echo "<h3>manufacturer_code</h3>", $decoder->manufacturer_code();

    // Example: serial_number
    echo "<h3>serial_number</h3>", $decoder->serial_number();

    // Example: raw_production_date
    echo "<h3>raw_production_date</h3>", $decoder->raw_production_date();

    // Example: production_month
    echo "<h3>production_month</h3>", $decoder->production_month();

    // Example: production_year
    echo "<h3>production_year</h3>", $decoder->production_year();

    // Example: model_year
    echo "<h3>model_year</h3>", $decoder->model_year();

    // Example: HIN manufacturer
    echo "<h3>manufacturer</h3>", $decoder->manufacturer();
  } catch (Exception $e) {
    echo "<h3>HIN is invalid</h3>", "Failed for: ", $e->getMessage();
  }

  echo "<hr>";
}
