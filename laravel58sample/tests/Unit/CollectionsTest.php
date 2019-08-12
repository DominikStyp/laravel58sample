<?php


namespace Tests\Unit;


use Illuminate\Support\Collection;
use Tests\TestCase;

class CollectionsTest extends TestCase {

    public function testCountMultidimensionalArray() {
        $arr = [];
        $arr[1][1] = 1;
        $arr[3][2] = 2;
        $arr[3][3][1] = 3;
        $arr[3][3][2] = 4;
        $arr[3][3][3] = 5;
        $arr[3][3][4][1] = 15;
        // regular count counts only 1 dimension
        $this->assertEquals(2, count($arr));
        // !!! WARNING !!! count with recursive parameter gives 10
        // because at $arr[1] we have an another array, and in that array we have element, so arrays are also counted
        $this->assertEquals(10, count($arr, COUNT_RECURSIVE));
        // laravel count
        $this->assertEquals(6, collect($arr)->flatten()->count());
        // array_walk_recursive count
        $walkCounter = 0;
        array_walk_recursive($arr, function($element) use (& $walkCounter) {
            $walkCounter++;
        });
        $this->assertEquals(6, $walkCounter);
    }

    public function testGroupMultidimensionalArrays1() {
        $data = collect([
            10 => ['user' => "Peter", 'skill' => 1, 'roles' => ['admin', 'moderator', 'viewer']],
            20 => ['user' => "John", 'skill' => 1, 'roles' => ['admin', 'viewer']],
            30 => ['user' => "Forrest", 'skill' => 2, 'roles' => ['admin']],
            40 => ['user' => "Jason", 'skill' => 2, 'roles' => ['moderator']],
            50 => ['user' => "Daniel", 'skill' => 3, 'roles' => ['admin']],
        ]);
        $result = $data->groupBy([
            'skill',
            function ($item) {
                return $item['roles'];
            },
        ], true);
        $resArr = $result->toArray();
        // first we look after grouped skill [2],
        // than after grouped roles ["moderator"]
        // than we get key() of the first element of that array
        // and first value of the array which is current() value
        $skill2Moderators = $resArr[2]["moderator"];
        $skill2Moderators_key = key($skill2Moderators);
        $skill2Moderators_value = current($skill2Moderators);
        $this->assertEquals(40, $skill2Moderators_key);
        $this->assertEquals("Jason", $skill2Moderators_value["user"]);

    }

    public function testGroupMultidimensionalArrays2() {
        $data = collect([
            10 => ['user' => "Peter", 'skill' => 1, 'roles' => ['admin', 'moderator', 'viewer']],
            20 => ['user' => "John", 'skill' => 1, 'roles' => ['admin', 'viewer']],
            30 => ['user' => "Forrest", 'skill' => 2, 'roles' => ['admin']],
            40 => ['user' => "Jason", 'skill' => 2, 'roles' => ['moderator']],
            50 => ['user' => "Daniel", 'skill' => 3, 'roles' => ['admin']],
            60 => ['user' => "Hank", 'skill' => 1, 'roles' => ['admin', 'viewer']],
        ]);
        $result = $data->groupBy([
            'skill',
            function ($item) {
                return $item['roles'];
            },
        ], true);
        // retrieve people with skill 1
        $result->get(1)
               // filter by moderator
               ->filter(function($value, $key) {
                        return $key === "moderator";
                })
               ->each(function($skillCollection, $key){
                        /** @var $skillCollection Collection */
                        $skillCollection->each(function($user, $key){
                            // only Peter is the mooderator in our grouped collection
                            $this->assertEquals("Peter", $user["user"]);
                            var_dump($key);
                            var_dump($user);
                        });
            });
    }

    public function testEachSpreadOnCollection(){
        $collection = collect([
            ['name' => 'John', 'age' => 30],
            ['name' => 'Cat', 'age' => 4],
        ]);
        // to remove sting keys from nested arrays
        // we need to: 1) map each element (array
        //             2) turn it from array to a collection
        //             3) flatten it
        //             4) turn it to array again
        $collection = $collection->map(function($value, $key){
            return collect($value)->flatten()->toArray();
        });
        // here we spread each array key to the function arguments
        // ['John', 30] ==>  function('John', 30){ }
        $collection->eachSpread(function ($name, $age) {
            $this->assertTrue(in_array($name, ['John', 'Cat']));
            $this->assertTrue(in_array($age, [30, 4]));
        });
    }


}