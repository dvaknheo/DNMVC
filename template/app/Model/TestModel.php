<?php
namespace MY\Model;

use MY\Base\BaseModel;
//use MY\Base\Helper\ModelHelper as M;

class TestModel extends BaseModel
{
    public function foo()
    {
        return DATE(DATE_ATOM);
    }
}
