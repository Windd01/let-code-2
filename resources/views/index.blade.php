@extends('layout.master')

@section('content')

    <div class="title m-b-md">
        Dân số thế giới.
    </div>

    <div class="container">
        <div style="text-align: left"><h3>Tổng quốc gia : <span>{{$allRecord->total_countries}}</span></h3>
            <h3>Tổng dân số : <span>{{$allRecord->world_population}}</span></h3></div>
        <div>
        </div>
        <div class="row mb-4">
            <div class="col-6"><a href="{{route('index')}}" class="btn @if($route == 'index') btn-dark @else btn-outline-dark @endif btn-lg">Top 20</a></div>
            <div class="col-6"><a href="{{route('all-country')}}" class="btn @if($route == 'all-country') btn-dark @else btn-outline-dark @endif btn-lg">Tất cả</a></div>
        </div>
        <div class="card">
            <div class="card card-header">
                <h5>@if($route == 'index') Top 20 quốc gia đông dân nhất  @else Toàn bộ quốc gia @endif</h5>
            </div>
            <div class="card card-body">
                <table class="table">
                    <thead>
                    <tr>
                        <th scope="col">Rank</th>
                        <th scope="col">Country Name</th>
                        <th scope="col">Population</th>
                    </tr>
                    </thead>
                    <tbody id="table-body">
                    @foreach($result as $key => $value)
                        <tr>
                            <td>{{$value->ranking ?? ''}}</td>
                            <td>{{$key}}</td>
                            <td>{{$value->population ?? ''}}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            <div class="card card-footer">
                <div style="text-align: right" class="mt-2">
                    @if($page > 1)
                        <a href="{{route($route, ['page' => $page - 1])}}" class="btn btn-primary"><</a>
                    @endif
                    <span class="btn btn-primary">{{$page}}</span>
                    @if($page * 10 < $total )
                        <a href="{{route($route, ['page' => $page + 1])}}" class="btn btn-primary">></a>
                    @endif
                </div>
            </div>
        </div>


    </div>
    <script>
        $('#search').select2();
    </script>
@endsection
