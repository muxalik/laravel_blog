@extends('admin.layouts.layout')

@section('title', 'Home')

@section('content')

  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Главная</h1>
        </div>
      </div>
    </div>
  </section>

  <section class="content">
    <div class="container-fluid">
      <div class="row">

        <div class="col-lg-3 col-6">
          <div class="small-box bg-info">
            <div class="inner">
              <h3 id="posts_count">0</h3>
              <p>Total Posts</p>
            </div>
            <div class="icon">
              <i class="ion ion-document"></i>
            </div>
            <a href="{{ route('posts.index') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
          </div>
        </div>
        
        <div class="col-lg-3 col-6">
          <div class="small-box bg-success">
            <div class="inner">
              <h3 id="views_count">0</h3>
              <p>Average Views</p>
            </div>
            <div class="icon">
              <i class="ion ion-stats-bars"></i>
            </div>
            <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
          </div>
        </div>
        
        <div class="col-lg-3 col-6">
          <div class="small-box bg-warning">
            <div class="inner">
              <h3 id="users_count">0</h3>
              <p>User Registrations</p>
            </div>
            <div class="icon">
              <i class="fas fa-user-plus"></i>
            </div>
            <a href="{{ route('users.index') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
          </div>
        </div>
      
        <div class="col-lg-3 col-6">
          <div class="small-box bg-danger">
            <div class="inner">
              <h3 id="rating_count">0</h3>
              <p>Average Rating</p>
            </div>
            <div class="icon">
              <i class="fas fa-chart-pie"></i>
            </div>
            <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
          </div>
        </div>
        
      </div>

      <div class="row">
        <div class="col-12">
          <div class="card">

            <div class="card-header" id="card">
              <h3 class="card-title">Список админов</h3>
              <div class="card-tools">
              <div class="input-group input-group-sm" style="width: 150px;">
              <input type="text" name="table_search" class="form-control float-right" placeholder="Search">
              <div class="input-group-append">
              <button type="submit" class="btn btn-default">
              <i class="fas fa-search"></i>
              </button>
              </div>
              </div>
              </div>
            </div>
            
            <div class="card-body table-responsive p-0" style="max-height: 300px;" id="table">
              @if (count($admins))
                <table class="table table-head-fixed table-bordered table-hover text-nowrap">
                  <thead>
                    <tr>
                      <th style="width: 30px; text-align: center; padding-left: 0.75rem">#</th>
                      <th>Имя</th>
                      <th>Email</th>
                      <th>Регистрация</th>
                      <th>Последнее посещение</th>
                      <th>Действия</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach($admins as $admin)
                      <tr>
                        <td style="width: 30px; text-align: center; padding-left: 0.75rem">{{ $admin->id }}</td>
                        <td>{{ $admin->name }}</td>
                        <td>{{ $admin->email }}</td>
                        <td>{{ $admin->created_at }}</td>
                        <td>{{ $admin->updated_at }}</td>
                        <td class="table_actions">
                          <a href="{{ route('users.edit', ['user' => $admin->id]) }}" class="btn btn-info btn-sm float-left mr-1 table-action" title="Редактировать">
                            <i class="fas fa-pencil-alt"></i>
                          </a>
                          <form action="{{ route('users.destroy', ['user' => $admin->id]) }}" method="POST" class="float-left mr-1 table-action" title="Удалить">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm action-delete">
                              <i class="fas fa-trash-alt"></i>
                            </button>
                          </form>
                        </td>
                      </tr>
                    @endforeach
                  </tbody>
                </table>
              @else
                <p style="padding: 0.75rem 1.25rem 0">Админов пока нет...</p>
              @endif
            </div>
          </div>
        
        </div>
      </div>
      <div class="row">
        <div class="col-md-6">

          <div class="card card-info">
            <div class="card-header">
              <h3 class="card-title">Popular tags</h3>
              <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                  <i class="fas fa-minus"></i>
                </button>
                <button type="button" class="btn btn-tool" id="maximize" data-card-widget="maximize">
                  <i class="fas fa-expand"></i>
                </button>
                <button type="button" class="btn btn-tool" data-card-widget="remove">
                  <i class="fas fa-times"></i>
                </button>
              </div>
            </div>
            <div class="card-body"><div class="chartjs-size-monitor"><div class="chartjs-size-monitor-expand"><div class=""></div></div><div class="chartjs-size-monitor-shrink"><div class=""></div></div></div>
              <canvas id="donutChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%; display: block; width: 797px;" width="797" height="250" class="chartjs-render-monitor"></canvas>
            </div>
          </div>
        
          <div class="card card-success">
            <div class="card-header">
              <h3 class="card-title">Rating of latest posts</h3>
              <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                  <i class="fas fa-minus"></i>
                </button>
                <button type="button" class="btn btn-tool" id="maximize" data-card-widget="maximize">
                  <i class="fas fa-expand"></i>
                </button>
                <button type="button" class="btn btn-tool" data-card-widget="remove">
                  <i class="fas fa-times"></i>
                </button>
              </div>
            </div>
            <div class="card-body">
              <div class="chart"><div class="chartjs-size-monitor"><div class="chartjs-size-monitor-expand"><div class=""></div></div><div class="chartjs-size-monitor-shrink"><div class=""></div></div></div>
                <canvas id="barChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%; display: block; width: 797px;" width="797" height="250" class="chartjs-render-monitor"></canvas>
              </div>
            </div>
          </div>
        
        </div>
        
        <div class="col-md-6">
        
          <div class="card card-info">
            <div class="card-header">
              <h3 class="card-title">Popular categories</h3>
              <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                  <i class="fas fa-minus"></i>
                </button>
                <button type="button" class="btn btn-tool" id="maximize" data-card-widget="maximize">
                  <i class="fas fa-expand"></i>
                </button>
                <button type="button" class="btn btn-tool" data-card-widget="remove">
                  <i class="fas fa-times"></i>
                </button>
              </div>
            </div>
            <div class="card-body"><div class="chartjs-size-monitor"><div class="chartjs-size-monitor-expand"><div class=""></div></div><div class="chartjs-size-monitor-shrink"><div class=""></div></div></div>
              <canvas id="pieChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%; display: block; width: 797px;" width="797" height="250" class="chartjs-render-monitor"></canvas>
            </div>
          </div>
        
          <div class="card card-success">
            <div class="card-header">
              <h3 class="card-title">Rating of popular posts</h3>
              <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                  <i class="fas fa-minus"></i>
                </button>
                <button type="button" class="btn btn-tool" id="maximize" data-card-widget="maximize">
                  <i class="fas fa-expand"></i>
                </button>
                <button type="button" class="btn btn-tool" data-card-widget="remove">
                  <i class="fas fa-times"></i>
                </button>
              </div>
            </div>
            <div class="card-body">
              <div class="chart"><div class="chartjs-size-monitor"><div class="chartjs-size-monitor-expand"><div class=""></div></div><div class="chartjs-size-monitor-shrink"><div class=""></div></div></div>
                <canvas id="stackedBarChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%; display: block; width: 797px;" width="797" height="250" class="chartjs-render-monitor"></canvas>
              </div>
            </div>
          </div>
        
        </div>
        
      </div>
    </div>
    <script async>
      $(function () {
    /* ChartJS
     * -------
     * Here we will create a few charts using ChartJS
     */

    //-------------
    //- DONUT CHART -
    //-------------
    // Get context with jQuery - using jQuery's .get() method.
    var donutChartCanvas = $('#donutChart').get(0).getContext('2d')
    var donutData        = {
      labels: {!! $tags_labels !!},
      datasets: [
        {
          data: {!! $tags_posts !!},
          backgroundColor : ['#f56954', '#00a65a', '#f39c12', '#00c0ef', '#3c8dbc', '#d2d6de'],
        }
      ]
    }
    var donutOptions     = {
      maintainAspectRatio : false,
      responsive : true,
    }
    //Create pie or douhnut chart
    // You can switch between pie and douhnut using the method below.
    new Chart(donutChartCanvas, {
      type: 'doughnut',
      data: donutData,
      options: donutOptions
    })

    //-------------
    //- popular categories -
    //-------------
    // Get context with jQuery - using jQuery's .get() method.
    var pieChartCanvas = $('#pieChart').get(0).getContext('2d')
    var pieData        = {
      labels: {!! $categories_labels !!},
      datasets: [
        {
          data: {!! $categories_posts !!},
          backgroundColor : ['#f56954', '#00a65a', '#f39c12', '#00c0ef', '#3c8dbc', '#d2d6de'],
        }
      ]
    };
    var pieOptions     = {
      maintainAspectRatio : false,
      responsive : true,
    }
    //Create pie or douhnut chart
    // You can switch between pie and douhnut using the method below.
    new Chart(pieChartCanvas, {
      type: 'pie',
      data: pieData,
      options: pieOptions
    })

    //-------------
    //- latest posts -
    //-------------

    var barChartCanvas = $('#barChart').get(0).getContext('2d')

    var barChartData = {
      labels  : {!! $latest_labels !!},
      datasets: [
        {
          label               : 'Likes',
          backgroundColor     : 'rgba(60,141,188,0.9)',
          borderColor         : 'rgba(60,141,188,0.8)',
          pointRadius         : false,
          pointColor          : '#3b8bba',
          pointStrokeColor    : 'rgba(60,141,188,1)',
          pointHighlightFill  : '#fff',
          pointHighlightStroke: 'rgba(60,141,188,1)',
          data                : {!! $latest_likes !!}
        },
        {
          label               : 'Dislikes',
          backgroundColor     : 'rgba(210, 214, 222, 1)',
          borderColor         : 'rgba(210, 214, 222, 1)',
          pointRadius         : false,
          pointColor          : 'rgba(210, 214, 222, 1)',
          pointStrokeColor    : '#c1c7d1',
          pointHighlightFill  : '#fff',
          pointHighlightStroke: 'rgba(220,220,220,1)',
          data                : {!! $latest_dislikes !!}
        },
      ]
    }

    var barChartOptions = {
      responsive              : true,
      maintainAspectRatio     : false,
      datasetFill             : false
    }

    new Chart(barChartCanvas, {
      type: 'bar',
      data: barChartData,
      options: barChartOptions
    })

    //---------------------
    //- popular posts -
    //---------------------
    var areaChartCanvas = $('#stackedBarChart').get(0).getContext('2d')
    const areaChartData = {
      labels: {!! $popular_labels !!},
      datasets: [
        {
          label               : 'Dislikes',
          backgroundColor     : 'rgba(210, 214, 222, 1)',
          borderColor         : 'transparent',
          pointRadius         : false,
          pointColor          : 'rgba(210, 214, 222, 1)',
          pointStrokeColor    : '#c1c7d1',
          pointHighlightFill  : '#fff',
          pointHighlightStroke: 'rgba(210, 214, 222, 1)',
          fill                : 'start',
          data                : {!! $popular_dislikes !!}
        },
        {
          label               : 'Likes',
          borderColor         : 'transparent',
          backgroundColor     : 'rgba(60,141,188,0.9)',
          pointRadius         : false,
          pointColor          : '#3b8bba',
          pointStrokeColor    : 'rgba(60,141,188,0.9)',
          pointHighlightFill  : '#fff',
          pointHighlightStroke: 'rgba(60,141,188,0.9)',
          fill                : 'start',
          data                : {!! $popular_likes !!},
        },
        
      ]
    };

    const areaChartConfig = {
      type: 'line',
      data: areaChartData,
      options: {
        plugins: {
          filler: {
            propagate: false,
          }
        },
        interaction: {
          intersect: false,
        },
        maintainAspectRatio : false,
        responsive : true,
        elements : {
          line : {
            tension : .3
          }
        }
      }
    };

    const areaChart = new Chart(
      areaChartCanvas,
      areaChartConfig,
    );
  })
    </script>
  </section>

@endsection

@section('countUp')

  <script type="module">
    import { CountUp } from '/js/countUp.min.js';

    window.onload = function() {
      new CountUp('posts_count', {{ $posts_count }}, { enableScrollSpy: true })
      .handleScroll();

      new CountUp('views_count', {{ $avg_views }}, { enableScrollSpy: true })
      .handleScroll();

      new CountUp('users_count', {{ $users_count }}, { enableScrollSpy: true })
      .handleScroll();

      new CountUp('rating_count', {{ $avg_rating }}, { enableScrollSpy: true })
      .handleScroll();
    }

    
  </script>

@endsection