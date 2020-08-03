@extends('layouts.app')

@section('header')
<header class="header header-inverse h-fullscreen pb-80" data-parallax="{{ asset('assets/img/bg-man.jpg ') }}" data-overlay="8">
    <div class="container text-center">

    <div class="row h-full">
        <div class="col-12 col-lg-8 offset-lg-2 align-self-center">

        <h1 class="display-4 hidden-sm-down">HAPPYCASTS</h1>
        <h1 class="hidden-md-up">THE BEST WEB DEVELOPMENT SCREENCASTS ON THE INTERNET</h1>
        <br>
        <p class="lead text-white fs-20 hidden-sm-down"><span class="fw-400">Happycasts</span> is an awesome web development learning<br>subscription based SaaS  application powered with Vuejs and <span class="mark-border">Laravel 5.5   </span>.</p>


        <br><br><br>


        <a class="btn btn-lg btn-round w-200 btn-primary mr-16" href="#" data-scrollto="section-intro">Demos</a>
        <a class="btn btn-lg btn-round w-200 btn-outline btn-white hidden-sm-down" href="#" data-scrollto="section-intro">Features</a>

        </div>


        <div class="col-12 align-self-end text-center">
        <a class="scroll-down-1 scroll-down-inverse" href="#" data-scrollto="section-intro"><span></span></a>
        </div>

    </div>

    </div>
</header>
@stop

@section('content')
      <section class="section" id="section-intro">
        <div class="container">
          <header class="section-header">
            <small>lessons</small>
            <h2>Featured Screencasts</h2>
            <hr>
            <p class="lead"></p>
          </header>

                      <div class="row gap-y">

 </div>
        </div>
      </section>
@stop 
