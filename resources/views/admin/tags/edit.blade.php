@extends('admin.layouts.layout')

@section('content')
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Редактирование тега</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active">Blank Page</li>
          </ol>
        </div>
      </div>
    </div><!-- /.container-fluid -->
  </section>

  <!-- Main content -->
  <section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Тег {{ $tag->title }}</h3>
                    </div>

                    <form role="form" method="POST" action="{{ route('tags.update', ['tag' => $tag->id]) }}">
                        @csrf
                        @method('PUT')
                        <div class="card-body">
                            <div class="form-group">
                                <label for="title">Название</label>
                                <input type="text" name="title" class="form-control @error('title') is-invalid @enderror" id="title" value="{{ $tag->title }}">
                            </div>
                        </div>
                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">Сохранить</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
  </section>

  <script src="{{ asset('ckeditor/build/ckeditor.js') }}"></script>
  <script src="{{ asset('ckfinder/ckfinder.js') }}"></script>

  <script>

    ClassicEditor
        .create( document.querySelector( '#content' ), {
            ckfinder: {
                uploadUrl: '/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files&responseType=json'
            },
            image: {
              toolbar: [ 'imageTextAlternative', '|', 'imageStyle:alignLeft', 'imageStyle:full', 'imageStyle:alignRight' ],
              styles: [
                'full',
                'alignLeft',
                'alignRight'
              ] 
            },
            toolbar: {
                items: [
                  'heading',
                  '|',
                  'bold',
                  'italic',
                  'link',
                  'bulletedList',
                  'numberedList',
                  '|',
                  'outdent',
                  'indent',
                  'alignment',
                  '|',
                  'blockQuote',
                  'insertTable',
                  'undo',
                  'redo',
                  'CKFinder',
                  'mediaEmbed'
                ]
              },
              language: 'ru',
              image: {
                toolbar: [
                  'imageTextAlternative',
                  'imageStyle:inline',
                  'imageStyle:block',
                  'imageStyle:side'
                ]
              },
              table: {
                contentToolbar: [
                  'tableColumn',
                  'tableRow',
                  'mergeTableCells'
                ]
              }
        } )
        .catch( function( error ) {
            console.error( error );
        } );

    ClassicEditor
        .create( document.querySelector( '#description' ), {
            toolbar: [ 'heading', '|', 'bold', 'italic', '|', 'undo', 'redo' ]
        } )
        .catch( function( error ) {
            console.error( error );
        } );
        
        $(function () {
          bsCustomFileInput.init();
        });
      
  </script>
  <!-- /.content -->
@endsection