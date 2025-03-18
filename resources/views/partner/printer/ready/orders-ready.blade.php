@php
$pageTitle = "Orders Ready for Collection";
$orderStatus = "ready";
$routePrefix = "partner.printer.ready-x";
$emptyMessage = "No orders ready for collection.";
$columnHeaders = ['Date', 'Order ID', 'Customer', 'Email', 'Remaining Payment', 'Total Payment'];
@endphp

@extends('partner.printer.layout.printer-order-template')