<?php
# @Author: Alec M. <amattu>
# @Date:   2021-09-01
# @Last modified by:   amattu
# @Last modified time: 2021-09-02 10:54:56
# @License: GNU Affero General Public License v3.0
# @Copyright: Alec M.

// Class namespace
namespace amattu;

// Exceptions
class InvalidHINException extends \Exception {};

/*
 Hull Identification Number Class
 */
class HIN {
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
   * The length of a valid HIN
   *
   * @var int
   */
  public const LENGTH = 12;

  /**
   * Characters allowed in a serial number
   *
   * @var string
   */
  public const VALID_SN_CHARACTERS = "ABCDEFGHJKLMNPRSTUVWXYZ1234567890";

  /**
   * Class Constructor
   *
   * @param string $HIN hull ID number
   * @throws TypeError
   * @throws InvalidHINException
   * @author Alec M. <https://amattu.com>
   * @date 2021-09-01
   */
  public function __construct(string $HIN)
  {
    // Set HIN
    $this->HIN = strtoupper($HIN);

    // Check Length
    if (strlen($HIN) !== HIN::LENGTH)
      throw new InvalidHINException("The provided HIN does not meet length expected");

    // Check Manufacturer Code
    $manufacturer_code = $this->manufacturer_code();
    if (!preg_match("/[A-Z0-9]/i", $manufacturer_code))
      throw new InvalidHINException("The HIN has an invalid Manufacturer Code");

    // Check Serial Characters
    $serial_number = $this->serial_number();
    for ($i = 0; $i < strlen($serial_number); $i++)
      if (strpos(HIN::VALID_SN_CHARACTERS, $serial_number[$i]) === false)
        throw new InvalidHINException("Found invalid character {$serial_number[$i]} in HIN serial number");

    // Check Production Date
    $production_date = $this->raw_production_date();
    if (!preg_match("/[A-L]/i", $production_date[0]))
      throw new InvalidHINException("The HIN production month is not valid");
    if (!is_numeric($production_date[1]))
      throw new InvalidHINException("The HIN production year is not valid");

    // Check Model Year
    $model_year = $this->raw_model_year();
    if (!is_numeric($model_year))
      throw new InvalidHINException("The indicated HIN model year is not valid");
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
    return "{$this->HIN} [MY: {$this->model_year()}]";
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
    return substr($this->HIN, 0, 3);
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
    return substr($this->HIN, 3, 5);
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
    return substr($this->HIN, 8, 2);
  }

  /**
   * Get the hull month of manufacture
   *
   * @return string (MM) format for production month
   * @throws None
   * @author Alec M. <https://amattu.com>
   * @date 2021-09-01
   */
  public function production_month() : string
  {
    // Find Month
    switch ($this->HIN[8]) {
      case "A":
        return "01";
      case "B":
        return "02";
      case "C":
        return "03";
      case "D":
        return "04";
      case "E":
        return "05";
      case "F":
        return "06";
      case "G":
        return "07";
      case "H":
        return "08";
      case "I":
        return "09";
      case "J":
        return "10";
      case "K":
        return "11";
      case "L":
        return "12";
    }
  }

  /**
   * Get the hull year of manufacture
   *
   * NOTE:
   *   (1) This is NOT the model year. Use model_year for that
   *
   * @return int hull production year (YYYY)
   * @throws None
   * @author Alec M. <https://amattu.com>
   * @date 2021-09-02T09:17:06-040
   */
  public function production_year() : int
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
   * Get hull raw model year
   *
   * NOTE:
   *   (1) This is unformatted, and in a (YY) date format.
   *
   * @return int [description]
   * @throws
   * @author Alec M. <https://amattu.com>
   * @date 2021-09-02Tfalse10:false38:false40-040
   */
  public function raw_model_year() : int
  {
    return substr($this->HIN, 10, 2);
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
    $model_year_2 = substr($this->HIN, 10, 2);
    if (!is_numeric($model_year_2))
      return 0;

    // Convert 2-digit year to 4-digit
    $model_year_dt = \DateTime::createFromFormat("y", $model_year_2);
    $model_year_4 = (int) $model_year_dt->format("Y");
    if ($model_year_4 < HIN::MINIMUM_YEAR)
      return 0;

    // Return
    return $model_year_4;
  }

  public function manufacturer() : string
  {
    return "TBD";
  }
}
