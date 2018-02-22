<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\libs\DataBaseInterfaces\TicketsI;
use App\libs\DataBaseInterfaces\CommentsI;
use App\libs\DataBaseInterfaces\CategoryI;
use App\libs\DataBaseInterfaces\VotesI;
use Illuminate\Container\Container;



class ExampleTest extends TestCase
{
   
    /**
     * A basic test example.
     *
     * @return void
     */

    

    public function testBasicTest()
    {
        $response = $this->get('/');
        $response->assertRedirect('/login');
       // $response->assertStatus(200);
    }

    public function testUnitTickets()
    {
        $container = Container::getInstance();
        $instance = $container->make(TicketsI::class);
        $this->assertTrue(
            $instance->getTickets()
            ->get()
            ->contains('id', 1)
        );
        $this->assertFalse(
            $instance->getTickets()
            ->get()
            ->contains('id', 0)
        );
    }

    public function testUnitVotes()
    {
        $container = Container::getInstance();
        $instance = $container->make(VotesI::class);
        
        $this->assertTrue(
            $instance->getVotes()
            ->contains('id', 1)
        );

        $this->assertNotEmpty(
            $instance->getTopVotes()
        );
 
        $this->assertNotEmpty(
            $instance->Totalvotes('SPHCL7JFOF')
        );
        
        $this->assertFalse(
            $instance->getVotes()
            ->contains('id', 0)
        );
    }
}
