<?php
class modTwform
{
    // Модуль автоматически создаёт классы для стилизации формы на TailwindCSS

    public $app;
    public $dom;
    private $control;
    private $checks;
    private $select;
    private $fgroup;
    private $stop;
    private $text = "text-sm";
    private $label = "text-sm font-medium text-gray-600";
    private $border = "border-gray-200 focus:border-indigo-500 focus:outline-none";
    private $rounded = "md";
    private $shadow = "shadow-sm";


    function __construct($dom)
    {
        $this->app = &$dom->app;
        $this->dom = &$dom;
        $this->stop = 'twform';
        wbIsDom($dom) ? $this->init() : null;
    }

    function init()
    {
        $this->control = "block w-full px-2 py-2 border text-gray-600 {$this->text} {$this->border} rounded-{$this->rounded} {$this->shadow}";
        $this->checks = 'flex gap gap-4 w-full py-2';
        $this->select = 'flex gap gap-4 w-full';
        $this->fgroup = "inline-flex items-center px-2 {$this->text} text-gray-500 border {$this->border} bg-gray-50 {$this->shadow}";
        $inputs = $this->dom->find("input,textarea,select,.form-group");
        $this->dom->attr('id') > '' ? null : $this->dom->attr('id',$this->app->newId('_','form'));
        foreach ($inputs as $inp) {
            if ($inp->attr('type') !== 'hidden' && !$inp->hasClass($this->stop)) {
                $tag = $inp->tag();
                method_exists($this, $tag) ? $this->$tag($inp) : $this->other($inp);
                $inp->addClass($this->stop);
            }
        }
        $this->dom->find('.'.$this->stop)->removeClass('.' . $this->stop);
    }

    function wrap($inp) {
        if ($inp->hasClass($this->stop)) return;
        $label = $inp->prev('label');
        $flex = $label->length && $label->hasClass('w-full') ? 'flex-wrap' : 'sm:flex-nowrap flex';
        if ($label->length && !$label->attr('class')) {
            $label->addClass('sm:w-1/4');
        }
        $label->length ? $label->addClass($this->label) : null;
        $gap = $inp->parent('wb-multiinput')->length ? '' : 'gap-4';
        $inp->wrap("<div class='{$flex} items-start items-center {$gap} py-1'></div>");

        $label->length ? $label->prependTo($inp->parent('div')) : null;
    }

    function input(&$inp, $self = false)
    {
        if ($inp->hasClass($this->stop)) return;
        if (in_array($inp->attr('type'), ['checkbox', 'radio'])) {
            $tagtype = $inp->tag()."[type={$inp->attr('type')}]";
            $inp->addClass("h-5 w-5 rounded-{$this->rounded} border-gray-300 text-indigo-600 focus:ring-indigo-500");
            $sub = $inp->next($tagtype);
            if (!$self) {
                $this->wrap($inp);
                $inp->wrap("<div class='{$this->checks}'</div>");
            }
            $inp->addClass($this->stop);
            $self == false ? $self = $inp : null;
            if ($sub->length && $self !== false) {
                $this->input($sub, $self);
                $sub->addClass($this->stop);
                $sub->appendTo($self->parent());
            }
        } else {
            if ($inp->parent()->hasClass('form-group')) {
                if ($inp->prev()->length) {
                    $inp->addClass('rounded-l-none');
                    $inp->prev()->addClass("border-r-0 rounded-r-none rounded-l-{$this->rounded} ".$this->fgroup);
                }
                if ($inp->next()->length) {
                    $inp->addClass('rounded-r-none mr-[1px]');
                    $inp->next()->addClass("border-l-0 rounded-l-none rounded-r-{$this->rounded} ". $this->fgroup);
                }
                $inp->parent()->addClass('sm:w-3/4');
                $this->wrap($inp->parent());
            } else {
                $this->wrap($inp);
            }
            $inp->addClass($this->control);
            $inp->parents('.form-group')->length ? $inp->parent()->addClass('w-full') : null;
        }
    }

    function textarea(&$inp)
    {
        $inp->addClass($this->control);
        $this->wrap($inp);
    }
    function select(&$inp)
    {
        $inp->addClass($this->control);
        $this->wrap($inp);
        $inp->wrap("<div class='{$this->select}'</div>");
    }

    function other($inp) {
        if ($inp->is('.form-group')) {
            $inp->addClass('flex w-full');
            $this->wrap($inp);
        }

    }
}
?>