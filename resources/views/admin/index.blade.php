@extends('admin.layouts.layout')

@section('content')

  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Главная</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active">Blank Page</li>
          </ol>
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
              <h3>{{ $posts_count }}</h3>
              <p>Total Posts</p>
            </div>
            <div class="icon">
              <i class="ion ion-document"></i>
            </div>
            <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
          </div>
        </div>
        
        <div class="col-lg-3 col-6">
          <div class="small-box bg-success">
            <div class="inner">
              <h3>53<sup style="font-size: 20px">%</sup></h3>
              <p>Bounce Rate</p>
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
              <h3>{{ $users_count }}</h3>
              <p>User Registrations</p>
            </div>
            <div class="icon">
              <i class="fas fa-user-plus"></i>
            </div>
            <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
          </div>
        </div>
      
        <div class="col-lg-3 col-6">
          <div class="small-box bg-danger">
            <div class="inner">
              <h3>65</h3>
              <p>Unique Visitors</p>
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
            <div class="card-header">
              <h3 class="card-title">Fixed Header Table</h3>
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
            
            <div class="card-body table-responsive p-0" style="height: 300px;">
            <table class="table table-head-fixed text-nowrap">
            <thead>
            <tr>
            <th>ID</th>
            <th>User</th>
            <th>Date</th>
            <th>Status</th>
            <th>Reason</th>
            </tr>
            </thead>
            <tbody>
            <tr>
            <td>183</td>
            <td>John Doe</td>
            <td>11-7-2014</td>
            <td><span class="tag tag-success">Approved</span></td>
            <td>Bacon ipsum dolor sit amet salami venison chicken flank fatback doner.</td>
            </tr>
            <tr>
            <td>219</td>
            <td>Alexander Pierce</td>
            <td>11-7-2014</td>
            <td><span class="tag tag-warning">Pending</span></td>
            <td>Bacon ipsum dolor sit amet salami venison chicken flank fatback doner.</td>
            </tr>
            <tr>
            <td>657</td>
            <td>Bob Doe</td>
            <td>11-7-2014</td>
            <td><span class="tag tag-primary">Approved</span></td>
            <td>Bacon ipsum dolor sit amet salami venison chicken flank fatback doner.</td>
            </tr>
            <tr>
            <td>175</td>
            <td>Mike Doe</td>
            <td>11-7-2014</td>
            <td><span class="tag tag-danger">Denied</span></td>
            <td>Bacon ipsum dolor sit amet salami venison chicken flank fatback doner.</td>
            </tr>
            <tr>
            <td>134</td>
            <td>Jim Doe</td>
            <td>11-7-2014</td>
            <td><span class="tag tag-success">Approved</span></td>
            <td>Bacon ipsum dolor sit amet salami venison chicken flank fatback doner.</td>
            </tr>
            <tr>
            <td>494</td>
            <td>Victoria Doe</td>
            <td>11-7-2014</td>
            <td><span class="tag tag-warning">Pending</span></td>
            <td>Bacon ipsum dolor sit amet salami venison chicken flank fatback doner.</td>
            </tr>
            <tr>
            <td>832</td>
            <td>Michael Doe</td>
            <td>11-7-2014</td>
            <td><span class="tag tag-primary">Approved</span></td>
            <td>Bacon ipsum dolor sit amet salami venison chicken flank fatback doner.</td>
            </tr>
            <tr>
            <td>982</td>
            <td>Rocky Doe</td>
            <td>11-7-2014</td>
            <td><span class="tag tag-danger">Denied</span></td>
            <td>Bacon ipsum dolor sit amet salami venison chicken flank fatback doner.</td>
            </tr>
            </tbody>
            </table>
            </div>
          
          </div>
        
        </div>
      </div>
    </div>

  </section>

@endsection