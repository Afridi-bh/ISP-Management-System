@extends('customer.layouts.app')

@section('content')
<h2>Ticket #{{ $ticketDetails->id }}</h2>
<p>{{ $ticketDetails->subject }}</p>
<p>{{ $ticketDetails->description }}</p>

<a href="{{ route('customer.support') }}">Back</a>
@endsection
