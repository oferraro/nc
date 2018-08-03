<?php

namespace novicap;

require 'novicap.php';

class ScansTest extends \PHPUnit\Framework\TestCase
{
    public function testScanMethod () {
        $nc = new novicap();
        $scanResult = $nc->scan("VOUCHER");
        $this->assertInternalType('boolean', $scanResult);
    }

    public function testScanUnexistingProd () {
        $nc = new novicap();
        $scanResult = $nc->scan("UNEXSISTENT");
        $this->assertInternalType('boolean', $scanResult);
    }
    
    public function testTotalWithBasicBuy () {
        /* Items: VOUCHER, TSHIRT, MUG */
        $nc = new novicap();
        $nc->scan("VOUCHER");
        $nc->scan("TSHIRT");
        $nc->scan("MUG");
        $total = $nc->getTotal();
        $this->assertEquals(32.5, $total); // Total: 32.50€
    }

    public function testTotalWith2x1 () {
        /*Items: VOUCHER, TSHIRT, VOUCHER */
        $nc = new novicap();
        $nc->scan("VOUCHER");
        $nc->scan("TSHIRT");
        $nc->scan("VOUCHER");
        $total = $nc->getTotal();
        $this->assertEquals(25.0, $total); // Total: 25.0€
    }

    public function testTotalWithBulk () {
        /*Items: TSHIRT, TSHIRT, TSHIRT, VOUCHER, TSHIRT */
        $nc = new novicap();
        $nc->scan("TSHIRT");
        $nc->scan("TSHIRT");
        $nc->scan("TSHIRT");
        $nc->scan("VOUCHER");
        $nc->scan("TSHIRT");
        $total = $nc->getTotal();
        $this->assertEquals(81.0, $total); // Total: 81.0€
    }

    public function testTotalWith2x1AndBulk () {
        /*Items: VOUCHER, TSHIRT, VOUCHER, VOUCHER, MUG, TSHIRT, TSHIRT */
        $nc = new novicap();
        $nc->scan("VOUCHER");
        $nc->scan("TSHIRT");
        $nc->scan("VOUCHER");
        $nc->scan("VOUCHER");
        $nc->scan("MUG");
        $nc->scan("TSHIRT");
        $nc->scan("TSHIRT");
        $total = $nc->getTotal();
        $this->assertEquals(74.5, $total); // Total: 74.5€
    }

}