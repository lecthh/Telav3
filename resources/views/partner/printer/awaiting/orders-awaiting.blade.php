@php
$pageTitle = "Orders Awaiting Printing";
$orderStatus = "awaiting-printing";
$routePrefix = "partner.printer.awaiting-x";
$emptyMessage = "No orders awaiting printing.";
$columnHeaders = ['Date', 'Order ID', 'Customer', 'Email', 'Apparel', 'Production', 'Order Type'];
@endphp

@extends('partner.printer.layout.printer-order-template')