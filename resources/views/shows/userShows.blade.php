@extends('app')

@section('content')
    <div class="container">
        <h1>Your TV Shows</h1>
        <div class="table-responsive">
            <table id='user_shows_table' class="display">
                <thead>
                <tr>
                    <th>Name</th>
                    <th>Type</th>
                    <th>Un Follow</th>
                </tr>
                </thead>
                <tbody>
                @foreach($shows as $show)
                    <tr>
                        <td><a href="{{ url('shows').'/'.$show->id }}">{{$show->name}}</a></td>
                        <td>{{$show->type}}</td>
                        <td><a class="btn btn-danger" href="{{url('shows/unfollow').'/'.$show->id}}">UnFollow</a></td>
                    </tr>
                @endforeach



                </tbody>

            </table>
        </div>
        <div>
            @if($shows->count()==0)
                Your don't follow any shows. click <a href="{{ url('shows') }}">here</a> to follow some.
            @endif
        </div>

    </div>
@endsection

@include('partial.datatable',['table_name'=>'user_shows_table','columns'=>'0'])
