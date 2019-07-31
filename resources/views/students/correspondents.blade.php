@extends('app')

@section('title', 'Liste')

@section('content')
    <div class="container-fluid">
    @foreach($correspondents->chunk(4) as $items)
        <div class="row mt-3 pl-3">
            @foreach($items as $item)
                <div class="col-sm-3 pl-0">
                    <div class="card" style="">
                        <img src="https://placeimg.com/640/480/any" class="card-img-top" alt="...">
                        <div class="card-body">
                            <h5 class="card-title">{{ $item->name }}</h5>
                            <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                            <div class="float-right">
                                <a href="{{ route('messages.create', ['recipient' => $item->id]) }}" class="btn btn-primary"><i class="fas fa-paper-plane"></i> {{ trans('buttons.contact') }}</a>
                                <a href="{{ route('students.show',  ['recipient' => $item->id]) }}" class="btn btn-primary"><i class="fas fa-eye"></i> {{ trans('buttons.see') }}</a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endforeach
    </div>
@endsection
