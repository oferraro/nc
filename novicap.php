<?php

namespace novicap;

class novicap {
    const PRODS = [ "VOUCHER" => ["price" => 5.0], 
                    "TSHIRT" => ["price" => 20.0], 
                    "MUG" => ["price" => 7.5]];
    public $total = 0;
    private $scanned = [];

    public function scan ($prod) {
        if (!isset(self::PRODS[$prod])) {
            return false;
        } else {
            if (isset($this->scanned[$prod])) {
                $this->scanned[$prod]++;
            } else {
                $this->scanned[$prod] = 1;
            }
            return true;
        }
    }

    public function getTotal() {
        $voucherQty = $this->scanned['VOUCHER'];
        $voucherPrice = self::PRODS['VOUCHER']['price'];
        if ($voucherQty%2===0) { // If we have pair amount of VOUCHERs
            $vPrice = ($voucherQty*$voucherPrice)/2;
        } else  { 
            /* With unpair VOUCHERs remove one VOUCHER and calc 2x1 of them
               finally add the missing one with normal price */
            $vPrice = (($voucherQty-1)*$voucherPrice)/2;
            $vPrice+= $voucherPrice;
        }
        $tshirtQty = $this->scanned['TSHIRT'];
        $tshirtPrice = self::PRODS['TSHIRT']['price'];
        if ($tshirtQty >= 3) {
            $tshirtPrice--;
        }
        $tsPrice = $tshirtQty * $tshirtPrice;
        $mPrice = 0;
        if (isset($this->scanned['MUG'])) {
            $mugQty = $this->scanned['MUG'];
            $mPrice = self::PRODS['MUG']['price'];
            $mPrice = $mugQty * $mPrice;
        }
        return $vPrice + $tsPrice + $mPrice; //$this->total + SELF::PRODS[$prod]["price"];
    }

}
