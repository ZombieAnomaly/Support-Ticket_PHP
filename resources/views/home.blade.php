<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
</head>

<?php $nav = true ?>
@extends('layouts.app',compact('nav'));

@section('title', 'Dashboard')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Dashboard</div>

                <div class="panel-body">
                    <p>You are logged in!</p>

                    @if (Auth::user()->is_admin)
                        <p>
                            See all <a href="{{ url('admin/tickets') }}">tickets</a>
                        </p>
                    @else
                        <p>
                            See all your <a href="{{ url('my_tickets') }}">tickets</a> or <a href="{{ url('new_ticket') }}">open new ticket</a>
                        </p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection