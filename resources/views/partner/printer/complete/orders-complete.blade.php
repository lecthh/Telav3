@php
$pageTitle = "Completed Orders";
$orderStatus = "completed";
$routePrefix = "partner.printer.completed-x";
$emptyMessage = "No completed orders.";
$columnHeaders = ['Date', 'Order ID', 'Customer', 'Email', 'Total Payment'];
@endphp

@extends('partner.printer.layout.printer-order-template')