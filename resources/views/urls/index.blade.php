@extends('layouts.app')
@section('main')
<main class="flex-grow-1">
    <div class="container-lg">
        <h1 class="mt-5 mb-3">Сайты</h1>
        <div class="table-responsive">
            <table class="table table-bordered table-hover text-nowrap">
                <tbody>
                    <tr>
                        <th>ID</th>
                        <th>Имя</th>
                        <th>Последняя проверка</th>
                        <th>Код ответа</th>
                    </tr>
                @forelse ($urls as $url)
                    <tr>
                        <td>{{$url->id}}</td>
                        <td><a href="{{route('urls.show', ['url' => $url->id])}}">{{$url->name}}</a></td>
                        <td> asdf</td>
                        <td>200</td>
                    </tr>
                @empty
                   Ничего не найдено               
                @endforelse
                </tbody>
            </table>
            <nav>
                <ul class="pagination">
                    <li class="page-item disabled" aria-disabled="true" aria-label="« Previous">
                        <span class="page-link" aria-hidden="true">‹</span>
                    </li>
                    <li class="page-item active" aria-current="page"><span class="page-link">1</span></li>
                    <li class="page-item"><a class="page-link" href="https://php-l3-page-analyzer.herokuapp.com/urls?page=2">2</a></li>
                    <li class="page-item"><a class="page-link" href="https://php-l3-page-analyzer.herokuapp.com/urls?page=3">3</a></li>
                    <li class="page-item"><a class="page-link" href="https://php-l3-page-analyzer.herokuapp.com/urls?page=4">4</a></li>
                    <li class="page-item"><a class="page-link" href="https://php-l3-page-analyzer.herokuapp.com/urls?page=5">5</a></li>
                    <li class="page-item">
                        <a class="page-link" href="https://php-l3-page-analyzer.herokuapp.com/urls?page=2" rel="next" aria-label="Next »">›</a>
                    </li>
                </ul>
            </nav>
        </div>
    </div>
</main>
@endsection