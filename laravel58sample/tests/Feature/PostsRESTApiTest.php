<?php

namespace Tests\Feature;

use App\Models\Post;
use App\User;
use Illuminate\Http\Response;
use Tests\TestCase;

class PostsRESTApiTest extends TestCase
{

    private $testUser = [
        'name' => 'Dominik123',
        'email' => 'dominik@gmail.com',
        'password' => '123123123',
        'password_confirmation' => '123123123',
    ];

    private function getTestUserApiToken(){
        $user = User::where('email', $this->testUser['email'])->first();
        return $user->api_token;
    }

    public function testRegister()
    {
        $response = $this->postJson("/api/register", $this->testUser);
        $content = $response->getContent();
        $arr = json_decode($content, true);
        $this->assertRegExp("/[a-zA-Z0-9]+/", $arr['data']['api_token']);
        $this->assertIsInt($arr['data']['id']);
        $this->assertEquals($this->testUser['name'], $arr['data']['name']);
        $this->assertEquals($this->testUser['email'], $arr['data']['email']);
    }
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

    public function testStorePost()
    {
        $response = $this->postJson('/api/posts', [
            'api_token' => $this->getTestUserApiToken(),
            'title' => "BLAH BLAH BLAH",
            'content' => 'CONTENT 123',
        ]);
        $response->assertStatus(Response::HTTP_CREATED);
        $lastPost = Post::orderBy('id', 'desc')->first();
        $this->assertEquals("BLAH BLAH BLAH", $lastPost->title);
        $this->assertEquals("CONTENT 123", $lastPost->content);
    }

    public function testShowPost()
    {
        $lastPost = Post::orderBy('id', 'desc')->first();
        $response = $this->get("/api/posts/{$lastPost->id}");
        $response->assertStatus(Response::HTTP_OK);
        $content = $response->getContent();
        $arr = json_decode($content, true);
        $this->assertEquals("BLAH BLAH BLAH", $arr['title']);
        $this->assertEquals("CONTENT 123", $arr['content']);
    }

    /**
     * @expectedException PHPUnit\Framework\ExpectationFailedException
     */
    public function testUpdateUnauthorizedNoApiToken()
    {
        $lastPost = Post::orderBy('id', 'desc')->first();
        $response = $this->put("/api/posts/{$lastPost->id}", [
            'title' => "UUU",
        ]);
        $response->assertStatus(Response::HTTP_OK);
    }


    /**
     * @expectedException PHPUnit\Framework\ExpectationFailedException
     */
    public function testUpdateUnauthorizedBecauseOfWrongUser()
    {
        $lastPost = Post::orderBy('id', 'desc')->first();
        $response = $this->put("/api/posts/{$lastPost->id}", [
            'title' => "UUU",
            'api_token' => User::find(mt_rand(1,20))->api_token
        ]);
        $response->assertStatus(Response::HTTP_OK);
    }


    /**
     * @expectedException PHPUnit\Framework\ExpectationFailedException
     */
    public function testDeleteUnauthorizedNoApiToken()
    {
        $lastPost = Post::orderBy('id', 'desc')->first();
        $response = $this->delete("/api/posts/{$lastPost->id}", []);
        $response->assertStatus(Response::HTTP_NO_CONTENT);
    }

    public function testUpdateAuthorizedAsAdmin()
    {

        $lastPost = Post::orderBy('id', 'desc')->first();
        $response = $this->put("/api/posts/{$lastPost->id}", [
            'title' => "UUU",
            'api_token' => $this->getTestUserApiToken()
        ]);
        $response->assertStatus(Response::HTTP_OK);
        $lastPostNextCheck = Post::find($lastPost->id);
        $this->assertEquals("UUU", $lastPostNextCheck->title);
    }

    public function testLoginUserAndGetTokenFromResponse()
    {
        $response = $this->postJson("/api/login", [
            'email' => $this->testUser['email'],
            'password' => $this->testUser['password'],
        ]);

        $arr = json_decode($response->getContent(), true);
        $this->assertRegExp("/[a-zA-Z0-9]+/", $arr['data']['api_token']);
    }

    public function testUpdateAuthorizedAsPostOwner()
    {

        /** @var Post $randomPost */
        $randomPost = Post::find(10);
        /** @var User $postOwner */
        $postOwner = $randomPost->user;
        $apiToken = $postOwner->generateToken();
        $response = $this->put("/api/posts/{$randomPost->id}", [
            'title' => "UUU",
            'api_token' => $apiToken
        ]);
        $response->assertStatus(Response::HTTP_OK);
        $lastPostNextCheck = Post::find($randomPost->id);
        $this->assertEquals("UUU", $lastPostNextCheck->title);
    }

    public function testDeleteAuthorized()
    {
        $lastPost = Post::orderBy('id', 'desc')->first();
        $response = $this->delete("/api/posts/{$lastPost->id}", [
            'api_token' => $this->getTestUserApiToken()
        ]);
        $response->assertStatus(Response::HTTP_NO_CONTENT);
        $lastPostNextCheck = Post::find($lastPost->id);
        $this->assertEmpty($lastPostNextCheck);
    }


}
