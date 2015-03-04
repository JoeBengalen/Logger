<?php

class AbstractHanderTest extends PHPUnit_Framework_TestCase
{
    public function testInterpolate()
    {
        $data = [
            'info', // level
            'log {replace}', // message
            ['replace' => 'message'] // context
        ];
        
        $expected = [
            'info', // level
            'log message', // message
            ['replace' => 'message'] // context
        ];
        
        $result = call_user_func_array(new InvokableHandler(), $data);
        
        $this->assertEquals($result, $expected);
    }
}
