@extends('app')

@section('content')
    <div class="container">
        <h1>TV Shows</h1>
        <div class="table-responsive">
            <table id='show_table' class="display">
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
                            <td><a href="{{ url('shows').'/'.$show->id }}">{{$show->name}}</a></td>
                            <td>{{$show->type}}</td>
                            <td><a class="btn btn-success" href="{{url('shows/follow').'/'.$show->id}}">Follow</a></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

    </div>
@endsection

@include('partial.datatable',['table_name'=>'show_table','columns'=>'0'])