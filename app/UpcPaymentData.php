<?php


namespace UPC;

/**
 * @property string MerchantID
 * @property string TerminalID
 * @property int PurchaseTime
 * @property string OrderID
 * @property string Currency
 * @property int TotalAmount
 */
class UpcPaymentData implements UpcPaymentInterface
{
    public function __construct(string $MerchantID, string $TerminalID, int $PurchaseTime, string $OrderID,  string $Currency, int $TotalAmount)
    {
        $this->MerchantID = $MerchantID;
        $this->TerminalID = $TerminalID;
        $this->PurchaseTime = $PurchaseTime;
        $this->OrderID = $OrderID;
        $this->Currency = $Currency;
        $this->TotalAmount = $TotalAmount;
    }

    public function toArray()
    {
        return  [
            'MerchantID' => $this->MerchantID,
            'TerminalID' => $this->TerminalID,
            'PurchaseTime' => $this->PurchaseTime,
            'OrderID' => $this->OrderID,
            'Currency' => $this->Currency,
            'TotalAmount' => $this->TotalAmount,
        ];
    }
}