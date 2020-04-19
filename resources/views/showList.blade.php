@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">Dashboard</div>

                <div class="panel-body">
                    
                    <table class="table">
                        <thead>
                            <tr>
                                <th>星座名稱</th>
                                <th>整體運勢指數</th>
                                <th>整體運勢</th>
                                <th>愛情運勢指數</th>
                                <th>愛情運勢</th>
                                <th>事業運勢指數</th>
                                <th>事業運勢</th>
                                <th>財運運勢指數</th>
                                <th>財運運勢</th>
                                <th>時間</th>
                            </tr>
                        </thead>
                        <tbody>
                            
                            @foreach($posts as $v) 
                                <tr>
                                    <td>{{$v['astroName']}}</td>
                                    <td>{{$v['totalScore']}}</td>
                                    <td>{{$v['totalDesc']}}</td>
                                    <td>{{$v['loveScore']}}</td>
                                    <td>{{$v['loveDesc']}}</td>
                                    <td>{{$v['buissScore']}}</td>
                                    <td>{{$v['buissDesc']}}</td>
                                    <td>{{$v['finScore']}}</td>
                                    <td>{{$v['finDesc']}}</td>
                                    <td>{{$v['updated_at']}}</td>
                                </tr>
                            @endforeach

                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
