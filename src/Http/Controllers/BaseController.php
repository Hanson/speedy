<?php

namespace Hanson\Speedy\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Routing\Controller as LaravelBaseController;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Validator;
use Request;

class BaseController extends LaravelBaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected $permissionName;

    protected $validatePrefix = 'validator.admin.';

    protected $attributeTransPrefix = 'attribute.';

    public function __construct()
    {
        $this->middleware('speedy.auth:' . $this->permissionName);
    }

    /**
     * validate
     *
     * @param $key
     * @param bool|Request $isJson Request
     * @param null $uniqueColumn
     * @param null $uniqueId
     * @return $this|\Illuminate\Validation\Validator
     */
    public function mustValidate($key, $isJson = false, $uniqueColumn = null, $uniqueId = null)
    {
        $rules = config($this->getValidatePrefix() . $key);

        if($uniqueColumn){
            $rules[$uniqueColumn] .= ",$uniqueId";
        }

        $value = $isJson ? Request::json()->all() : Request::all();

        $validator = Validator::make($value, $rules, [], $this->getTranAttribute($key));

        return $validator;
    }

    public function success($data = [], $code = 200)
    {
        return ['code' => $code, 'data' => $data];
    }

    public function fail($data = [], $code = 500)
    {
        return ['code' => $code, 'data' => $data];
    }

    protected function getTranAttribute($key)
    {
        $trans = [];
        $model = current(explode('.', $key));
        $rules = config($this->getValidatePrefix() . $key);

        foreach ($rules as $name => $rule) {
            $trans[$name] = trans($this->getAttributeTranPrefix().$model. '.'.$name);
        }

        return $trans;
    }

    protected function getValidatePrefix()
    {
        return $this->validatePrefix;
    }

    protected function setValidatePrefix($prefix)
    {
        $this->validatePrefix = $prefix;
    }

    protected function getAttributeTranPrefix()
    {
        return $this->attributeTransPrefix;
    }

    protected function setAttributeTranPrefix($prefix)
    {
        $this->attributeTransPrefix = $prefix;
    }
}
