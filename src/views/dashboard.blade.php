@extends('admin::layouts.default')

@section('headline')
    <div> 
        <h1>Jarboe Docs</h1>
    </div>
@stop

@section('main')
<div id="content">

@include('admin::docs.install')
@include('admin::docs.config')
@include('admin::docs.table')
@include('admin::docs.filemanager')


@include('admin::docs.dino')




</div>
@stop



@section('styles')
<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/highlight.js/8.3/styles/railscasts.min.css">
@stop

@section('scripts')
<script src="//cdnjs.cloudflare.com/ajax/libs/highlight.js/8.3/highlight.min.js"></script>
<script>hljs.initHighlightingOnLoad();</script>
@stop
