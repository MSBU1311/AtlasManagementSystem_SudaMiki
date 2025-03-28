<x-sidebar>
<div class="board_area w-100 border m-auto d-flex">
  <div class="post_view w-75 mt-5 mb-5">
    @foreach($posts as $post)
    <div class="post_area border w-75 m-auto p-3">
      <p><span>{{ $post->user->over_name }}</span><span class="ml-3">{{ $post->user->under_name }}</span>さん</p>
      <p class="post_title"><a href="{{ route('post.detail', ['id' => $post->id]) }}">{{ $post->post_title }}</a></p>
      <div class="post_bottom_area d-flex">
          @foreach($post->subCategories as $subCategory)
            <p class="post_sub_category">{{ $subCategory->sub_category }}</p>
          @endforeach
        <div class="d-flex post_status">
          <div class="mr-5">
            <i class="fa fa-comment" style="color: gray"></i><span class="" style="color: gray">{{ $post_comment->commentCounts($post->id)->count() }}</span>
          </div>
          <div>
            <!-- ユーザーidとlike_user_idが一致していたら -->
            @if(Auth::user()->is_Like($post->id))
            <!-- likeモデルのlikeCountsメソッドを用いて、like_post_idカラムが今のpostのidと一致するレコードをカウントしている -->
            <p class="m-0"><i class="fas fa-heart un_like_btn" post_id="{{ $post->id }}"></i><span class="like_counts{{ $post->id }}">{{ $like->likeCounts($post->id) }}</span></p>
            @else
            <p class="m-0"><i class="fas fa-heart like_btn" post_id="{{ $post->id }}" style="color: gray"></i><span class="like_counts{{ $post->id }}">{{ $like->likeCounts($post->id) }}</span></p>
            @endif
          </div>
        </div>
      </div>
    </div>
    @endforeach
  </div>
  <div class="other_area  w-25">
    <div class=" m-4">
      <div class="d-grid gap-2">
        <a href="{{ route('post.input') }}" class="new_create btn btn-primary" style="background: #4CA7CE; border-color: #4CA7CE;">投稿</a>
      </div>
      <div class="key_word">
        <input class="kyeword_form" type="text" placeholder="キーワードを検索" name="keyword" form="postSearchRequest">
        <input type="submit" value="検索" form="postSearchRequest" class="keyword_button">
      </div>
      <div class="post_search">
        <input type="submit" name="like_posts" class="like_post" value="いいねした投稿" form="postSearchRequest">
        <input type="submit" name="my_posts" class="my_post" value="自分の投稿" form="postSearchRequest">
      </div>
      <ul>
        <li>カテゴリー検索</li>
        @foreach($categories as $category)
        <li class="" >
          <p class="main_categories" category_id="{{ $category->id }}">
            {{ $category->main_category }}
            <span class="arrow">&#8744;</span>
          </p><br>
          <!-- 各メインカテゴリーに対応するサブカテゴリーのグループを個別に操作できる -->
          <div class="category_num{{ $category->id }}">
            @foreach($category->subCategories as $sub_category)
              <input type="submit" name="category_word" class="sub_categories" value="{{ $sub_category->sub_category }}" form="postSearchRequest"><br>
            @endforeach
          </div>
        </li>
        @endforeach
      </ul>
    </div>
  </div>
  <form action="{{ route('post.show') }}" method="get" id="postSearchRequest"></form>
</div>
</x-sidebar>
