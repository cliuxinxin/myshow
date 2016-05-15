@extends('app')

@section('content')
    <div class="container">
        <h1>TV Shows</h1>
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Type</th>
                        <th>Follow</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($shows as $show)
                        <tr>
                            <td><a href="{{ url('episodes').'/'.$show->id }}">{{$show->name}}</a></td>
                            <td>{{$show->type}}</td>
                            <td><a class="btn btn-success" href="{{url('shows/follow').'/'.$show->id}}">Follow</a></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

    </div>
@endsection