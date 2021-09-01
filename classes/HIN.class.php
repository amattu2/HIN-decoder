<?php
# @Author: Alec M. <nachfolger>
# @Date:   2021-09-01
# @Last modified by:   nachfolger
# @Last modified time: 2021-09-01
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
   * Get HIN manufacturer code
   *
   * @return string MIC code
   * @throws None
   * @author Alec M. <https://amattu.com>
   * @date 2021-09-01
   */
  public function getMIC() : string
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
  public function getSN() : string
  {
    return substr($this->HIN, 3, 7);
  }

  /**
   * Get hull raw production date
   *
   * NOTE:
   *   (1) This does not return a human readable date,
   *   only two characters (i.e. D4) indicating the month (D)
   *   and year (4) of production.
   *   (2) In order for this information to be valuable,
   *   you would need to parse the month (A: Jan - L: Dec)
   *   and the year (4) IN COMBINATION with the last 2 digits
   *   of the HIN. See README.md for more info about this.
   *
   * @return string 2 character production date
   * @throws None
   * @author Alec M. <https://amattu.com>
   * @date 2021-09-01
   */
  public function getRawProductionDate() : string
  {
    return substr($this->HIN, 8, 9);
  }

  /**
   * Get the month of manufacturer
   *
   * NOTE:
   *   (1) A value of null indicates an invalid
   *   month of manufacturer
   *
   * @return int (M) format for production month
   * @throws None
   * @author Alec M. <https://amattu.com>
   * @date 2021-09-01
   */
  public function getProductionMonth() : ?int
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
}
