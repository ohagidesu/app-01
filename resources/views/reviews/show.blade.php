<!-- resources/views/reviews/show.blade.php -->

<!-- いいねボタン -->
<form id="likeForm" data-review-id="{{ $review->id }}" action="{{ route('reviews.like', $review->id) }}" method="post">
    @csrf
    <button type="submit" id="likeButton" class="{{ $review->likes->contains('user_id', auth()->id()) ? 'liked' : '' }}">
        <i class="fa fa-heart"></i>
    </button>
</form>

<!-- コメントフォーム -->
<form id="commentForm" data-review-id="{{ $review->id }}" action="{{ route('reviews.comment', $review->id) }}" method="post">
    @csrf
    <label for="title">コメントタイトル:</label>
    <input type="text" name="title" required>

    <label for="body">コメント本文:</label>
    <textarea name="body" required></textarea>

    <button type="submit">コメントする</button>
</form>

<!-- コメント一覧 -->
@foreach ($review->comments as $comment)
    <p>{{ $comment->title }}</p>
    <p>{{ $comment->body }}</p>
@endforeach

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const likeForm = document.getElementById('likeForm');
        const likeButton = document.getElementById('likeButton');

        likeForm.addEventListener('submit', function (e) {
            e.preventDefault();

            axios.post(likeForm.getAttribute('action'))
                .then(response => {
                    if (likeButton.classList.contains('liked')) {
                        likeButton.classList.remove('liked');
                    } else {
                        likeButton.classList.add('liked');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                });
        });
    });
</script>