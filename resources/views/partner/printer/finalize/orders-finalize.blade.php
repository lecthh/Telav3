@php
$pageTitle = "Orders Ready to Finalize";
$orderStatus = "finalize-order";
$routePrefix = "partner.printer.finalize-x";
$emptyMessage = "No orders ready to finalize.";
$columnHeaders = ['Date', 'Order ID', 'Customer', 'Email', 'Apparel', 'Designer', 'Filled'];
@endphp

@extends('partner.printer.layout.printer-order-template')