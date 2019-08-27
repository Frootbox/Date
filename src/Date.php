<?php
/**
 *
 */

namespace Frootbox\Dates;

class Date {
    
    protected $timestamp;


    /**
     *
     */
    public function __construct ( $date = null ) {

        if (!empty($date)) {
            $this->setDate($date);
        }

    }


    /**
     *
     */
    public function __toString ( ): string
    {
        return date('Y-m-d H:i:s', $this->timestamp);
    }


    /**
     *
     */
    public function format ( $format ) {

        return strftime($format, $this->timestamp);
    }


    /**
     *
     */
    public function setDate ( $date ): Date {

        // Match date like 23.08.19 12:00
        if (preg_match('#^([0-9]{1,2})\.([0-9]{1,2})\.([0-9]{1,4}) ([0-9]{1,2})\:([0-9]{1,2})$#', $date, $match))
        {
            $this->timestamp = mktime($match[4], $match[5], 0, $match[2], $match[1], $match[3]);
        }
        // Match date like 23.08.19
        elseif (preg_match('#^([0-9]{1,2})\.([0-9]{1,2})\.([0-9]{1,4})$#', $date, $match))
        {
            $this->timestamp = mktime(0, 0, 0, $match[2], $match[1], $match[3]);
        }
        // Match date like 2019-08-23 12:00:00
        else if (preg_match('#^([0-9]{4})\-([0-9]{2})\-([0-9]{2}) ([0-9]{2})\:([0-9]{2})\:([0-9]{2})$#', $date, $match))
        {
            $this->timestamp = mktime($match[4], $match[5], $match[6], $match[2], $match[3], $match[1]);
        }
        // Match date like 2019-08-23
        else if (preg_match('#^([0-9]{4})\-([0-9]{1,})\-([0-9]{1,})$#', $date, $match))
        {
            $this->timestamp = mktime(0, 0, 0, $match[2], $match[3], $match[1]);
        }
        // Match date like 19-08-23
        else if (preg_match('#^([0-9]{2})\-([0-9]{1,})\-([0-9]{1,})$#', $date, $match))
        {
            $this->timestamp = mktime(0, 0, 0, $match[2], $match[3], '20' . $match[1]);
        }
        else
        {
            throw new \Frootbox\Exceptions\InputInvalid('Invalid date string: ' . $date);
        }

        return $this;
    }
}