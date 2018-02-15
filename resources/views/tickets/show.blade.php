<?php $nav = true ?>
@extends('layouts.app',compact('nav'));

@section('title', $ticket->title)

@section('content')
    <div class="row">
        <div class="col-md-10 offset-md-0" >
            <div class="panel panel-default" style="padding-left: 10px;" >
                <div class="panel-heading">
                    #{{ $ticket->ticket_id }} - {{ $ticket->title }}
                </div>

                <div class="panel-body">
                    @include('includes.flash')

                    <div class="ticket-info">
                        <p>{{ $ticket->message }}</p>
                        <p>Categry: {{ $category->name }}</p>
                        <p>
                        @if ($ticket->status === 'Open')
                            Status: <span class="label label-success">{{ $ticket->status }}</span>
                        @else
                            Status: <span class="label label-danger">{{ $ticket->status }}</span>
                        @endif
                        </p>
                        <p>
                        @if ($ticket->visibility === 1)
                            Visibility: <i class="fas fa-eye"></i>
                        @else
                            Visibility: <i class="fas fa-eye-slash"></i>
                        @endif
                        </p>
                        <p>Created on: {{ $ticket->created_at->diffForHumans() }}</p>
                    </div>

                

                    <div class="comments">
                        @foreach ($comments as $comment)
                            <div class="panel panel-@if($ticket->user->id === $comment->user_id) {{"default"}}@else{{"success"}}@endif">
                            <hr>
                                <div class="panel panel-heading">
                                    <u>Author:</u> {{ $comment->user->name }}
                                    <span class="pull-right"><u>{{ $comment->created_at->format('Y-m-d') }}</u></span>
                                </div>

                                <div class="panel panel-body">
                                    {{ $comment->comment }}     
                                </div>
                            </div>
                        @endforeach
                    </div>  
                    @if ($ticket->status === "Open" || Auth::user()->is_admin)
                    <div class="comment-form">
                        <form action="{{ url('comment') }}" method="POST" class="form">
                            {!! csrf_field() !!}

                            <input type="hidden" name="ticket_id" value="{{ $ticket->id }}">

                            <div class="form-group{{ $errors->has('comment') ? ' has-error' : '' }}">
                                <textarea rows="10" id="comment" class="form-control" name="comment"></textarea>

                                @if ($errors->has('comment'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('comment') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="form-group">
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                        </form>
                </div>
                @endif
            </div>
        </div>
    </div>
@endsection