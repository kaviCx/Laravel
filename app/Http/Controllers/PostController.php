<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    function posts(Request $request){

        $postQuery = Post::query();
        if($request->search){
                $postQuery->where('title', 'like', '%' . $request->search . '%');
        }
        if($request->category){
            $postQuery->where('category_id', $request->category);

    }

    return view('posts.posts', ['posts' => $postQuery->get(), 'categories' => Category::all()]);
}

            public function index()
            {
                $posts = Post::with('category')->get();
                $categories = Category::all();
                return view('posts.index', compact('posts', 'categories'));
            }


            public function createPost()
            {
                $categories = Category::all();
                return view('posts.create', compact('categories'));
            }

            public function store(Request $request)
            {
                $validated = $request->validate([
                    'title' => 'required|max:255',
                    'content' => 'required',
                    'category_id' => 'required|exists:categories,id',
                ]);

                Post::create($validated);

                return redirect()->route('posts')->with('success', 'Post created successfully.');
            }

        public function editPost($id)
        {
            $post = Post::findOrFail($id);
            $categories = Category::all();
            return view('posts.edit', compact('post', 'categories'));
        }


        public function updatePost(Request $request, $id)
        {
            $request->validate([
                'title' => 'required|max:255',
                'content' => 'required',
                'category_id' => 'required|exists:categories,id',
            ]);

            $post = Post::findOrFail($id);
            $post->update([
                'title' => $request->title,
                'content' => $request->content,
                'category_id' => $request->category_id,
            ]);

            return redirect()->route('posts')->with('success', 'Post updated successfully');
        }

        public function deletePost($id)
        {
            $post = Post::findOrFail($id);
            $post->delete();
            return redirect()->route('posts')->with('success', 'Post deleted successfully');
        }

}
