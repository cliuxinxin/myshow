@extends('app')

@section('content')
    <div class="container">
        <h1>{{ $show->name }}</h1>
        <div class="table-responsive">
            <table id='episodes_table'class="display">
                <thead>
                <tr>
                    <th>Season</th>
                    <th>Episode</th>
                    <th>name</th>
                    <th>Date</th>
                    <th>Seen</th>
                </tr>
                </thead>
                <tbody>
                @foreach($episodes as $episode)
                    <tr>
                        <td>{{ $episode->season }}</td>
                        <td>{{ $episode->episode}}</td>
                        <td><a href="{{ $episode->url }}">{{ $episode->name }}</a></td>
                        <td>{{ $episode->date }}</td>
                        <td>
                            @if(count($user_episodes) == 0)
                                <a class="btn btn-success" href="{{url('episodes/seen').'/'.$episode->id}}">Seen</a>
                            @else
                                @if(count($user_episodes->where('id',$episode->id)))
                                    <a class="btn btn-danger" href="{{url('episodes/unseen').'/'.$episode->id}}">Unseen</a>
                                    @else
                                    <a class="btn btn-success" href="{{url('episodes/seen').'/'.$episode->id}}">Seen</a>
                                @endif
                            @endif

                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>

    </div>
@endsection

@include('partial.datatable',['table_name'=>'episodes_table'])