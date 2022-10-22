@foreach ($comments as $comment)
    <div class="media">
        <a class="media-left" href="#">
            <img src="{{ asset('images/avatar' . mt_rand(1, 5) . '.png') }}" alt="avatar" class="rounded-circle">
        </a>
        <div class="media-body">
            <h4 class="media-heading user_name">{{ $comment->user->name }}
                <small>{{ $comment->getDate() }}</small>
            </h4>
            <p>{{ $comment->content }}</p>
            <a href="" class="btn btn-primary btn-sm">Reply</a>
        </div>
    </div>
@endforeach
