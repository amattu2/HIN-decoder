# Introduction
This small PHP project is designed to aid those in need of interacting with boat HIN (hull identification numbers). See below for the usage section.

# Hull Identification Number (HIN) Format
The following table demonstrates the expected structuring to a valid hull ID number.

|Current Format (As of Aug 1, 1984)|
|--|--|--|--|
|BMA|45678|H4|85|
|MIC|Serial|Manufacturer Date|Model Year|

# Usage
## Setup
All functions except the constructor are unprompted error safe. That is, unless you provide an invalid argument (i.e. it's expecting an int and you pass a string).

```PHP
// Include required files
require("classes/HIN.class.php");

try {
  // Instantiate HIN decoder
  $HIN = new amattu\HIN("BMA45678H485");
} catch(Exception $e) { // Optional: Catch each exception individually
  echo $e->getMessage();
}
```

## __toString()
This class implements the `__toString` magic method.

```PHP
echo $HIN;
```

Example output:

`BMA45678H485 [MY: 1985]`

## manufacturer_code
Pull the first 3 digits of a HIN, which represent the manufacturer code.

```PHP
echo $HIN->manufacturer_code();
```

Example output:

`BMA`

## serial_number
Pull the serial number from the HIN.

```PHP
echo $HIN->serial_number();
```

Example output:

`45678`

## raw_production_date
Pull the raw production date from the HIN. This two-digit production date is not in a human readable format; and consist of a alphabetical character (i.e. `A`) and a digit (i.e. `3`). The first character represents the month, where `A` is `January`, and `L` is `December`. The digit represents the last digit of the production year, and needs to be used in conjunction with the last two digits of the HIN.

```PHP
echo $HIN->raw_production_date();
```

Example output:

`B4`

## production_month
This pulls and parses the production month from `raw_production_date`.

```PHP
echo $HIN->production_month();
```

Example output:

`02` (february)

## production_year
This parses the production year from `raw_production_date`.

```PHP
echo $HIN->production_year();
```

Example output:

`1984`

## model_year
This parses the MODEL YEAR (Not production year) from the HIN.

```PHP
echo $HIN->model_year();
```

Example output:

`1985`

## manufacturer
TBD

# Information Sources
A list of valuable HIN information sources is below.
- https://www.boatus.com/expert-advice/expert-advice-archive/2017/february/hull-identification-numbers
- https://drive.ky.gov/motor-vehicle-licensing/Pages/HIN.aspx#hin-location
- https://www.dol.wa.gov/forms/420739.pdf
- https://uscgboating.org/content/manufacturers-identification.php
- https://en.wikipedia.org/wiki/Hull_number

# Requirements & Dependencies
- PHP7+
