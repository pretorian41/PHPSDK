<?php


namespace UPC;


interface UpcInterface {
    public function signature(UpcPaymentData $data): string;
    public function tranState(UpcPaymentData $data, string $url);
}