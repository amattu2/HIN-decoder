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
    return substr($this->VIN, 3, 7);
  }
}
