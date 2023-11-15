@extends('layouts.app')

@section('content')
    <div class="container">
        <form action="{{ route('houses.store') }}" method="post">
            @csrf

            <label for="building">建物:</label>
            <select name="building" id="building">
                <option value="平屋">平屋</option>
                <option value="２階建て">２階建て</option>
                <option value="３階建て">３階建て</option>
            </select>

            <label for="interior">内装:</label>
            <select name="interior" id="interior">
                <option value="モダン">モダン</option>
                <option value="ナチュラル">ナチュラル</option>
                <option value="その他">その他</option>
            </select>

            <label for="budget">予算:</label>
            <select name="budget" id="budget">
                <option value="1000万未満">1000万未満</option>
                <option value="3000万未満">3000万未満</option>
                <option value="5000万未満">5000万未満</option>
                <option value="1億未満">1億未満</option>
                <option value="その他">その他</option>
            </select>

            <label for="hobby">趣味:</label>
            <input type="text" name="hobby" id="hobby" required>

            <button type="submit">登録</button>
        </form>
    </div>
@endsection