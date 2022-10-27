<?php


namespace UPC;


/**
 * @property string MerchantID
 * @property string TerminalID
 * @property int PurchaseTime
 * @property string OrderID
 * @property string Currency
 * @property string TotalAmount
 */
interface UpcPaymentInterface
{
    public function toArray();
}
