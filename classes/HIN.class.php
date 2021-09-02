<?php
# @Author: Alec M. <amattu>
# @Date:   2021-09-01
# @Last modified by:   amattu
# @Last modified time: 2021-09-02
# @License: GNU Affero General Public License v3.0
# @Copyright: Alec M.

// Class namespace
namespace amattu;

/*
 Hull Identification Number Class
 */
class HIN implements Stringable {
  /**
   * Hull Identification Number
   *
   * @var string
   */
  private $HIN = null;

  /**
   * Minimum supported HIN model year
   *
   * @var int
   */
  public const MINIMUM_YEAR = 1984;

  /**
   * Class Constructor
   *
   * @param string $HIN hull ID number
   * @throws TypeError
   * @author Alec M. <https://amattu.com>
   * @date 2021-09-01
   */
  public function __construct(string $HIN)
  {
    $this->HIN = strtoupper($HIN);
  }

  /**
   * Class toString function
   *
   * @return string class stringified
   * @throws None
   * @author Alec M. <https://amattu.com>
   * @date 2021-09-02T09:05:00-040
   */
  public function __tostring() : string
  {
    return $this->HIN;
  }

  /**
   * Get HIN manufacturer code
   *
   * @return string MIC code
   * @throws None
   * @author Alec M. <https://amattu.com>
   * @date 2021-09-01
   */
  public function manufacturer_code() : string
  {
    return substr($this->HIN, 0, 2);
  }

  /**
   * Get hull serial number
   *
   * @return string hull serial number
   * @throws None
   * @author Alec M. <https://amattu.com>
   * @date 2021-09-01
   */
  public function serial_number() : string
  {
    return substr($this->HIN, 3, 7);
  }

  /**
   * Get hull raw production date
   *
   * NOTE:
   *   (1) This does not return a human readable date,
   *   it's only two characters (i.e. D4) indicating the month (D)
   *   and year (4) of production.
   *   (2) In order for this information to be valuable,
   *   you would need to parse the month (A: Jan - L: Dec)
   *   and the year (4) IN COMBINATION with the last 2 digits
   *   of the HIN to know the decade.
   *   (3) See README.md for more info about the production date
   *
   * @return string 2 character production date
   * @throws None
   * @author Alec M. <https://amattu.com>
   * @date 2021-09-01
   */
  public function raw_production_date() : string
  {
    return substr($this->HIN, 8, 9);
  }

  /**
   * Get the month of manufacture
   *
   * NOTE:
   *   (1) A value of null indicates an invalid
   *   month of manufacture
   *
   * @return int (M) format for production month
   * @throws None
   * @author Alec M. <https://amattu.com>
   * @date 2021-09-01
   */
  public function production_month() : ?int
  {
    // Find Month
    switch ($this->HIN[8]) {
      case "A":
        return 1;
      case "B":
        return 2;
      case "C":
        return 3;
      case "D":
        return 4;
      case "E":
        return 5;
      case "F":
        return 6;
      case "G":
        return 7;
      case "H":
        return 8;
      case "I":
        return 9;
      case "J":
        return 10;
      case "K":
        return 11;
      case "L":
        return 12;
    }

    // Default
    return null;
  }

  /**
   * Get the year of manufacture
   *
   * NOTE:
   *   (1) This is NOT the model year. Use
   *   model_year for that
   *
   * @return int hull production year (YYYY)
   * @throws None
   * @author Alec M. <https://amattu.com>
   * @date 2021-09-02T09:17:06-040
   */
  public function production_year() : ?int
  {
    // Validate Model Year
    $model_year = $this->model_year();
    if ($model_year < HIN::MINIMUM_YEAR)
      return null;

    // Validate Production Year
    $production_year = $this->HIN[9];
    if (!is_numeric($production_year))
      return null;

    // Force model_year to string
    $model_year_string = (string) $model_year;
    $model_year_string[3] = $production_year;

    // Return
    return (int) $model_year_string;
  }

  /**
   * Determine a HIN model year
   *
   * @return int 4-digit model year
   * @throws None
   * @author Alec M. <https://amattu.com>
   * @date 2021-09-02T09:39:43-040
   */
  public function model_year() : int
  {
    // Validate Model Year
    $model_year_2 = substr($this->HIN, 10, 11);
    if (!is_numeric($model_year_2))
      return 0;

    // Convert 2-digit year to 4-digit
    $model_year_dt = \DateTime::createFromFormat("y", $model_year);
    $model_year_4 = $model_year_dt->format("Y");
    if ($model_year_4 < HIN::MINIMUM_YEAR)
      return 0;

    // Return
    return $model_year_4;
  }
}
