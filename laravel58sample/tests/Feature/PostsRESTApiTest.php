<?php

namespace Tests\Feature;

use App\Models\Post;
use Illuminate\Http\Response;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PostsRESTApiTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testIndex()
    {
        $response = $this->get('/api/posts');
        $content = $response->getContent();
        $arr = json_decode($content, true);
        $response->assertStatus(Response::HTTP_OK);
        $this->assertEquals(1, $arr[0]['id']);
        $this->assertEquals(2, $arr[1]['id']);
        $this->assertRegExp("/[A-Z]+\w+/", $arr[1]['title']);
        $this->assertRegExp("/[A-Z]+\w+/", $arr[1]['content']);
        $this->assertRegExp("/\d+/", $arr[1]['user_id']);
    }

    public function testStore()
    {
        $response = $this->postJson('/api/posts', [
            'title' => "BLAH BLAH BLAH",
            'content' => 'CONTENT 123',
            'user_id' => 5
        ]);
        $response->assertStatus(Response::HTTP_CREATED);
        $lastPost = Post::orderBy('id', 'desc')->first();
        $this->assertEquals(5, $lastPost->user_id);
        $this->assertEquals("BLAH BLAH BLAH", $lastPost->title);
        $this->assertEquals("CONTENT 123", $lastPost->content);
    }

    public function testShow()
    {
        $lastPost = Post::orderBy('id', 'desc')->first();
        $response = $this->get("/api/posts/{$lastPost->id}");
        $response->assertStatus(Response::HTTP_OK);
        $content = $response->getContent();
        $arr = json_decode($content, true);
        $this->assertEquals(5, $arr['user_id']);
        $this->assertEquals("BLAH BLAH BLAH", $arr['title']);
        $this->assertEquals("CONTENT 123", $arr['content']);
    }

    public function testUpdate()
    {
        $lastPost = Post::orderBy('id', 'desc')->first();
        $response = $this->put("/api/posts/{$lastPost->id}", [
            'title' => "UUU",
        ]);
        $response->assertStatus(Response::HTTP_OK);
        $lastPostNextCheck = Post::find($lastPost->id);
        $this->assertEquals(5, $lastPostNextCheck->user_id);
        $this->assertEquals("UUU", $lastPostNextCheck->title);
    }

    public function testDelete()
    {
        $lastPost = Post::orderBy('id', 'desc')->first();
        $response = $this->delete("/api/posts/{$lastPost->id}", []);
        $response->assertStatus(Response::HTTP_NO_CONTENT);
        $lastPostNextCheck = Post::find($lastPost->id);
        $this->assertEmpty($lastPostNextCheck);
    }

}
