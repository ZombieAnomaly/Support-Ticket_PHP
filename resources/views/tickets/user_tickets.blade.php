<!DOCTYPE html>

<?php $nav = true ?>
@extends('layouts.app',compact('nav'));

@section('title', 'My Tickets')

@section('content')
    <div class="row">
        <div class="col-md-10 offset-md-1">
            <div class="panel panel-default">
                <div class="panel-heading" align="center">
                    <h1><i class="fa fa-ticket"> My Tickets</i></h1>
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
                                    <th>Visibility</th>
                                    <th>Last Updated</th>
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
                                    <td>
                                    @if($ticket->visibility === 0)
                                        <i class="fas fa-eye-slash"></i>
                                    @else
                                        <i class="fas fa-eye"></i>
                                    @endif
                                    </td>
                                    <td>{{ $ticket->updated_at }}</td>
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
