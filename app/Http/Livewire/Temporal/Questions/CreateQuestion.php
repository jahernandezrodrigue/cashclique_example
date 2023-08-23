<?php

namespace App\Http\Livewire\Temporal\Questions;

use App\Http\Livewire\BaseComponent;
use App\Models\Temporal\Question;
use DB, Log;

class CreateQuestion extends BaseComponent
{
    public $open = false;
    public $isEdit = false;

    public Question $question;

    /**
     * rules 
     */
    protected $rules = [
        'question.name' => 'required',
        'question.isActive' => 'boolean',
    ];

    /**
     * Listeners
     */
    protected $listeners=[
        'createQuestion' => 'createQuestion',
        'editQuestion' => 'editQuestion',
        'closeModal' => 'closeModal',
        'render' => 'render',
    ];

    /**
     * render
     */
    public function render()
    {
        return view('livewire.temporal.questions.create-question');
    }

    /**
     * mount
     */
    public function mount()
    {
        // parent::mount();
        
        $this->question = new Question();
        $this->question->isActive = true;
    }

    /**
     * method open create
     */
    public function createQuestion()
    {
        $this->isEdit = false;
        $this->open = true;
    }

    /**
     * method open edit
     */
    public function editQuestion(Question $question)
    {
        $this->question = $question;
        $this->isEdit = true;
        $this->open = true;
    }

    /**
     * method close modal
     */
    public function closeModal()
    {
        $this->reset(['open', 'isEdit']);
        $this->question = new Question();
        $this->question->isActive = true;
    }

    /**
     * method submit
     */
    public function submit()
    {
        $this->validate();
        $this->isEdit ? $this->update():$this->store();
    }

    /**
     * method store
     */
    public function store()
    {
        DB::beginTransaction();
        try {
            // Create Question
            $question = $this->question;
            $question->save();

            // Commit Transaction
            DB::commit();

            $this->reset(['open', 'isEdit']);
            $this->question = new Question();
            $this->question->isActive = true;
            $this->emitTo('temporal.questions.index-questions', 'render');
            $this->emit('alert');

        } catch (\Exception $e) {
            DB::rollback();
            Log::error($e->getMessage());
            $this->emit('error_alert');
        } 
    }

    /**
     * method update
     */
    public function update()
    {
        DB::beginTransaction();
        try {
            // Create Question
            $question = $this->question;
            $question->save();

            // Commit Transaction
            DB::commit();

            $this->reset(['open', 'isEdit']);
            $this->question = new Question();
            $this->question->isActive = true;
            $this->emitTo('temporal.questions.index-questions', 'render');
            $this->emit('alert');
            
        } catch (\Exception $e) {
            DB::rollback();
            Log::error($e->getMessage());
            $this->emit('error_alert');
        } 
    }
}
