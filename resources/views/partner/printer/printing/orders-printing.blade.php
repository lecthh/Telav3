@php
$pageTitle = "Orders In Printing";
$orderStatus = "printing-in-progress";
$routePrefix = "partner.printer.printing-x";
$emptyMessage = "No orders in printing process.";
$columnHeaders = ['Date', 'Order ID', 'Customer', 'Email', 'Apparel', 'Production', 'Order Type'];
@endphp

@extends('partner.printer.layout.printer-order-template')