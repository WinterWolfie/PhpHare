<?php


namespace PhpHare\form;

use PhpHare\Model;

abstract class BaseField
{

    public Model $model;
    public string $attribute;

    /**
     * Field constructor.
     * @param $model
     */
    public function __construct(Model $model, string $attribute)
    {
        $this->model = $model;
        $this->attribute = $attribute;

    }


    abstract public function renderInput(): string;

    public function __toString(){
        return sprintf('
            <label >%s</label><br>
            %s
            <div class="invalid-feedback">
                %s
            </div>
        ',
            $this->model->getLabel($this->attribute),
            $this->renderInput(),
            $this->model->getFirstError($this->attribute)
        );
    }

}