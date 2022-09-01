@extends('admin.layouts.layout')

@section('title', 'Posts Create')

@section('content')
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Новая статья</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{ route('categories.index') }}">Статьи</a></li>
            <li class="breadcrumb-item active">Создание</li>
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
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Новая статья</h3>
                    </div>

                    <form role="form" method="POST" action="{{ route('posts.store') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="card-body card-full">
                            <div class="form-group">
                                <label for="title">Название</label>
                                <input type="text" name="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title') }}" id="title" placeholder="Название">
                            </div>

                            <div class="form-froup">
                              <label for="description">Цитата</label>
                              <textarea name="description" class="form-control @error('description') is-invalid @enderror" value="{{ old('description') }}" id="description" rows="5" placeholder="Цитата ..."></textarea>
                            </div>

                            <div class="form-froup">
                              <label for="content">Контент</label>
                              <textarea name="content" class="form-control @error('content') is-invalid @enderror" value="{{ old('content') }}" id="content" rows="5" placeholder="Контент ..."></textarea>
                            </div>

                            <div class="form-group">
                              <label for="category_id">Категория</label>
                              <select class="form-control @error('category_id') is-invalid @enderror" value="{{ old('category_id') }}" id="category_id" name="category_id">
                                @foreach ($categories as $k => $v)
                                  <option value="{{ $k }}">{{ $v }}</option>
                                @endforeach
                              </select>
                            </div>

                            <div class="form-group">
                              <label for="tags">Теги</label>
                              <select name="tags[]" class="select2" id="tags" multiple="multiple" data-placeholder="Выбор тегов" style="width: 100%;">
                                @foreach ($tags as $k => $v)
                                  <option value="{{ $k }}">{{ $v }}</option>
                                @endforeach
                              </select>
                            </div>

                            <script defer>

                              $(document).ready(function() {
                                $('.select2').select2();
                              });

                            </script>

                            <div class="form-group">
                              <label for="thumbnail">Изображение</label>
                              <div class="input-group">
                                <div class="custom-file">
                                <input type="file" name="thumbnail" class="custom-file-input" id="thumbnail">
                                <label class="custom-file-label" for="thumbnail">Choose file</label>
                                </div>
                              </div>
                            </div>

                            <script>

                              $(function () {
                                bsCustomFileInput.init();
                              });

                            </script>

                        </div>
                        <div class="card-footer">
                          <button type="submit" class="btn btn-primary mb-2 mr-2 my-icon-container">
                            <img src="{{ asset('images/icons/save_1.png') }}" class="my-icon" alt="save"> 
                            Сохранить
                          </button>
                          <a href="{{ route('posts.index') }}" class="btn btn-danger mb-2 mr-2 my-icon-container">
                            <img src="{{ asset('images/icons/cancel_1.png') }}" class="my-icon" alt="cancel"> 
                            Отменить
                          </a>
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