<?php

require_once './BaseController.php';

class BillController extends BaseController
{
    public function newBill()
    {

        $this->render("Bill/new_bill");
    }
}
