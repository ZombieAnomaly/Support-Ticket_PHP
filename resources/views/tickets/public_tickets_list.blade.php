<!DOCTYPE html>
<?php 
$nav = false;
use App\Http\Controllers\VotesController;
?>

@extends('layouts.app',compact('nav'));

@section('title', 'Public Tickets')
@section('content')
    <div class="row">
        <div class="col-md-10 offset-md-1">
            <div class="panel panel-default" >
                @include('includes.flash')
                <div class="panel-heading" align="center">
                    <h1><i class="fa fa-ticket"> Public Tickets</i></h1>
                </div>

                <div class="panel-body">
                    @if ($tickets->isEmpty())
                        <p>You have not created any tickets.</p>
                    @else
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Category</th>
                                    <th>ID</th>
                                    <th>Title</th>
                                    <th>Status</th>
                                    <th>Last Updated</th>
                                    <th>Votes</th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach ($tickets as $ticket)
                                <tr>
                                    <td>
                                    @foreach ($categories as $category)
                                        @if ($category->id === $ticket->category_id)
                                            {{ $category->name }}
                                        @endif
                                    @endforeach
                                    </td>
                                    <td>
                                    <a href="{{ url('tickets/'. $ticket->ticket_id) }}">
                                            {{ $ticket->ticket_id }}
                                        </a>
                                    </td>
                                    <td>{{ $ticket->title }}</td>
                                    <td>
                                    @if ($ticket->status === 'Open')
                                        <span class="label label-success">{{ $ticket->status }}</span>
                                    @else
                                        <span class="label label-danger">{{ $ticket->status }}</span>
                                    @endif
                                    </td>
                                    <td>{{ $ticket->updated_at }}</td>
                                    <td style="display:flex; justify-content:space-around;">
                                        <form style="" action="{{ url('upVote') }}" method="POST" class="form">
                                        {{ csrf_field() }}
                                            <input type="hidden" name="ticket" value="{{ $ticket->ticket_id }}">
                                            <input type="hidden" name="view" value="public_tickets_list">
                                            <div style="display:inline" class="form-group">
                                                <button type="submit" style="border:none;background:transparent;"><h2><i id="DownVote" class="fas fa-thumbs-up"></i></h2></button>
                                            </div>
                                        </form>

                                        <?php $ticketTotal = 0; ?>
                                        @foreach($votes as $v)
                                            @if ($v->ticket_id === $ticket->ticket_id AND $v->up == 1)
                                                <?php $ticketTotal += 1 ?>
                                            @elseif ($v->ticket_id === $ticket->ticket_id AND $v->down == 1)
                                                <?php $ticketTotal -= 1 ?>
                                            @endif
                                        @endforeach
                                        <h1 style=""> {{ $ticketTotal }}</h1>

                                        <form style="" action="{{ url('downVote') }}" method="POST" class="form">
                                        {{ csrf_field() }}
                                            <input type="hidden" name="ticket" value="{{ $ticket->ticket_id }}">
                                            <input type="hidden" name="view" value="public_tickets_list">
                                            <div style="display:inline" class="form-group">
                                            <button type="submit" style="border:none;background:transparent;"><h2><i id="DownVote" class="far fa-thumbs-down"></i></h2></button>
                                            </div>
                                        </form>

                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>

                        {{ $tickets->render() }}
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
